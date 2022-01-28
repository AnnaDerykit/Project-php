<?php

namespace App\Controllers;

use App\Framework\Response;
use App\Model\QueryBuilder;
use App\Model\TaskRepository;
use App\Model\User;
use Templates\ReportsView;

class ReportsController
{
    public static function index()
    {
        $response = new Response();
        $response->setContent(ReportsView::render([
            'script' => 'javascript/Reports.js'
        ]));
        return $response;
    }

    public static function filterData()
    {
        $projects = [];
        $clients = [];
        $dateFrom = null;
        $dateTo = null;
        $aggregate = false;
        foreach ($_POST as $key => $value) {
            if ($key == 'startTime' && $value != '') {
                $dateFrom = $value;
            } elseif ($key == 'stopTime' && $value != '') {
                $dateTo = $value;
            } elseif (preg_match('/^p/', $key)) {
                $projects[] = intval(ltrim($key, 'p'));
            } elseif (preg_match('/^c/', $key)) {
                $clients[] = intval(ltrim($key, 'c'));
            } elseif ($key == 'aggregation') {
                $aggregate = true;
            }
        }
        $qb = new QueryBuilder();
        if ($aggregate) {
            if ($projects && $clients) {
                $qb->select('p.projectName, c.clientName, p.wage, SUM(p.wage) AS totalTime, SUM(10 * p.wage) AS totalPayout');
                $qb->groupBy('c.clientName', 'p.projectName');
            }
            if ($projects && !$clients) {
                $qb->select('p.projectName, c.clientName, p.wage, SUM(p.wage) AS totalTime, SUM(p.wage * 10) AS totalPayout');
                $qb->groupBy('p.projectName');
            } elseif ($clients && !$projects) {
                $qb->select('c.clientName, SUM(p.wage) AS totalTime, SUM(10 * p.wage) AS totalPayout');
                $qb->groupBy('c.clientName');
            } else {
                $qb->select('t.title, p.projectName, c.clientName, p.wage, t.startTime, t.stopTime, 10 * p.wage AS totalTime, 20 * p.wage AS totalPayout');
            }
        } else {
            $qb->select('t.title, p.projectName, c.clientName, p.wage, t.startTime, t.stopTime, 10 * p.wage AS totalTime, 20 * p.wage AS totalPayout');
        }
        $qb->from('Task t')
            ->join('Project p', 't.projectId = p.id')
            ->join('Client c', 'p.clientId = c.id')
            ->where('t.userId', '=', [$_SESSION['uid']]);
        if ($projects && $clients) {
            $qb->where('p.id', '=', $projects, 'AND');
            $qb->where('c.id', '=', $clients, 'OR');
        } elseif ($projects) {
            $qb->where('p.id', '=', $projects, 'AND');
        } elseif ($clients) {
            $qb->where('c.id', '=', $clients, 'AND');
        }
        if ($dateFrom) {
            $qb->where('t.startTime', '>', [$dateFrom], 'AND');
        }
        if ($dateTo) {
            $qb->where('t.startTime', '<', [$dateTo], 'AND');
        }
        $qb->prepareStatement();
        $taskRep = new TaskRepository();
        $rows = $taskRep->executeQueryFromBuilder($qb);
        $response = json_encode($rows);
        header('Content-type: application/json');
        echo $response;
        exit;
    }
}