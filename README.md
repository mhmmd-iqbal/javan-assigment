This project use laravel 10.14.1, with PHP 8.1.10

The database, was run directly using above query, alongside query to get data from task 1

### Task 1
CREATE TABLE peoples (
	id INT AUTO_INCREMENT PRIMARY KEY,
  parent_id INT NULL,
  name VARCHAR(50) NOT NULL,
  gender ENUM('M', 'F'),
	FOREIGN KEY (parent_id) REFERENCES peoples(id) ON DELETE CASCADE
);

INSERT INTO `peoples` VALUES (1, NULL, 'Budi', 'M');
INSERT INTO `peoples` VALUES (2, 1, 'Dedi', 'M');
INSERT INTO `peoples` VALUES (3, 2, 'Feri', 'M');
INSERT INTO `peoples` VALUES (4, 2, 'Farah', 'F');
INSERT INTO `peoples` VALUES (5, 1, 'Dodi', 'M');
INSERT INTO `peoples` VALUES (6, 5, 'Gugus', 'M');
INSERT INTO `peoples` VALUES (7, 5, 'Gandi', 'M');
INSERT INTO `peoples` VALUES (8, 1, 'Dede', 'M');
INSERT INTO `peoples` VALUES (9, 8, 'Hani', 'F');
INSERT INTO `peoples` VALUES (10, 8, 'Hana', 'F');
INSERT INTO `peoples` VALUES (11, 1, 'Dewi', 'F');


SELECT child.name, child.gender 
FROM peoples parent
JOIN peoples child ON child.parent_id = parent.id
WHERE parent.name = 'Budi';

SELECT grandchild.name, grandchild.gender 
FROM peoples parent 
JOIN peoples child ON child.parent_id = parent.id
JOIN peoples grandchild ON grandchild.parent_id = child.id
WHERE parent.name = 'Budi';

SELECT grandchild.name, grandchild.gender 
FROM peoples parent 
JOIN peoples child ON child.parent_id = parent.id
JOIN peoples grandchild ON grandchild.parent_id = child.id
WHERE parent.name = 'Budi' and grandchild.gender = 'F';

SELECT child.name, child.gender 
FROM peoples parent 
JOIN peoples child ON child.parent_id = parent.id
LEFT JOIN peoples grandchild ON grandchild.parent_id = child.id
WHERE child.gender = 'F' AND parent.name = 'Budi';

SELECT grandchild.name, grandchild.gender 
FROM peoples parent 
JOIN peoples child ON child.parent_id = parent.id
JOIN peoples grandchild ON grandchild.parent_id = child.id
WHERE grandchild.gender = 'M';

### Task API
- get all data :  GET - {baseurl}

- get a data :    GET - {baseurl}/{:id}

- create a data :   POST - {baseurl}/store
--- parameter 
{
  name: "name",
  gender: "M",
  parent_id: null
}

- update a data : PUT - {baseurl}/update/{id}
--- parameter
{
  name: "name",
  gender: "M",
  parent_id: null
}

- deleted a data : DELETE - {baseurl}/delete/{id}
