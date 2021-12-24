INSERT INTO `User` (
`id` ,
`username` ,
`email` ,
`password` ,
`role`
)
VALUES (
NULL , 'Robert', 'rob@mail.com', 'rob', 'user'
), (
NULL , 'John', 'john@mail.com', 'john', 'user'
), (
NULL , 'Bobert', 'bob@mail.com', 'bob', 'user'
);

INSERT INTO `Client` (
`id` ,
`userId` ,
`clientName`
)
VALUES (
NULL , '1', 'ZUT'
), (
NULL , '1', 'WI3'
), (
NULL , '2', 'Skynet'
), (
NULL , '2', 'Evil Inc.'
), (
NULL , '3', 'A.C.M.E.'
);
