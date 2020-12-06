SELECT *
FROM students
FULL JOIN school ON students.school = school.idschool;

OU

SELECT *
FROM school
LEFT JOIN students
ON school.idschool = students.school
UNION ALL
SELECT *
FROM school
RIGHT JOIN students
ON school.idschool = students.school;

SELECT prenom FROM students;

SELECT students.prenom, students.datenaissance, school.school FROM students
LEFT JOIN school
ON students.school = school.idschool

SELECT students.prenom
FROM students
WHERE students.genre='F'

SELECT *
FROM students
WHERE students.school=(SELECT students.school FROM students WHERE students.nom = 'Addy')

SELECT students.prenom
FROM students
ORDER BY students.prenom DESC

SELECT students.prenom
FROM students
ORDER BY students.prenom DESC
LIMIT 0,2

INSERT INTO students(nom, prenom, datenaissance, genre, school)
VALUES('Dalor', 'Ginette', '1930-01-01','F', 1)

OU

INSERT INTO students(nom, prenom, datenaissance, genre, school)
VALUES('Dalor', 'Ginette', STR_TO_DATE('01/01/1930', '%d/%m/%Y'), 'F', (SELECT school.idschool FROM school WHERE school.school = 'Bruxelles'))

UPDATE students SET prenom = 'Omer', genre = 'M' WHERE prenom = 'Ginette' AND nom = 'Dalor'

DELETE FROM students WHERE students.idStudent = 3

ALTER TABLE students MODIFY students.school VARCHAR(20);
UPDATE students SET students.school = "Central" WHERE students.school = "1";
UPDATE students.school SET students.school = "Anderlecht" WHERE students.school = "2";