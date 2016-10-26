SELECT student.name, student.surname
FROM (SELECT payments.student_id, COUNT(payments.amount) AS payment_count
FROM (SELECT student_status.student_id
FROM (SELECT student_id, MAX(datetime) AS last_date FROM student_status GROUP BY student_id) AS student_last_date
INNER JOIN student_status
ON student_status.student_id=student_last_date.student_id AND student_status.datetime=student_last_date.last_date 
WHERE student_status.status='lost') AS lost_students
INNER JOIN payments
ON lost_students.student_id=payments.student_id
WHERE payments.amount <> 0 GROUP BY payments.student_id HAVING payment_count <=3) AS lost_students_payments
INNER JOIN student
ON student.id=lost_students_payments.student_id