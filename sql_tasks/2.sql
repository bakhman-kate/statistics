SELECT student.name, student.surname FROM student 
INNER JOIN 
(SELECT student_status.student_id
FROM (SELECT student_id, MAX(datetime) AS last_date FROM student_status GROUP BY student_id) AS student_last_date
INNER JOIN student_status
ON student_status.student_id=student_last_date.student_id AND student_status.datetime=student_last_date.last_date
WHERE student_status.status='vacation' 
) AS vacation_student
WHERE student.gender='unknown' AND student.id=vacation_student.student_id