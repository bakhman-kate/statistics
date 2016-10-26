<?php

/* @var $this yii\web\View */
use yii\helpers\Html;

$this->title = 'Test task';?>

<div class="site-index">
    <h1 class="text-center"><?=Html::encode('Вопросы по MySQL')?></h1>

    <div class="row">
        <div class="col-xs-12">
            <table class="table table-bordered table-hover table-condensed">
                <tr><th class="col-md-6 text-center">Задание</th><th class="col-md-6 text-center">Ответ</th></tr>
                <tr>
                    <td class="col-md-6">
                        <p>Есть таблица платежей пользователей:</p>
                        <code>CREATE TABLE payments ( 
                            id INT AUTO_INCREMENT PRIMARY KEY NOT NULL, 
                            student_id INT NOT NULL, 
                            datetime DATETIME NOT NULL, 
                            amount FLOAT DEFAULT 0, 
                            INDEX student_id ( student_id ) 
                            );</code>
                        <p>Необходимо составить запрос, который находит пользователя, сумма платежей которого находится на втором месте после максимальной.</p>
                    </td>
                    <td class="col-md-6">
                        <code>
                            SELECT student_id FROM payments 
                            GROUP BY student_id 
                            ORDER BY SUM(amount) DESC 
                            LIMIT 1 OFFSET 1 
                        </code>
                    </td>
                </tr>
                
                <tr>
                    <td class="col-md-6">
                        <p>Есть две таблицы. Первая содержит основные данные по студентам:</p>
                        <code>CREATE TABLE student ( 
                        id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
                        name VARCHAR(20) NOT NULL,
                        surname VARCHAR(20) DEFAULT '' NOT NULL,
                        gender ENUM('male', 'female', 'unknown') DEFAULT 'unknown',
                        INDEX gender ( gender ) 
                        );</code>
                        <p>Вторая содержит историю статусов студентов, где последний по хронологии статус является текущим:</p>
                        <code>CREATE TABLE student_status ( 
                        id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
                        student_id INT NOT NULL,
                        status ENUM('new', 'studying', 'vacation', 'testing', 'lost') DEFAULT 'new' NOT NULL,
                        datetime DATETIME NOT NULL,
                        INDEX student_id ( student_id ),
                        INDEX datetime ( datetime )
                        );</code>
                        <p>Необходимо показать имена и фамилии всех студентов, чей пол до сих не известен (gender = 'unknown') и они сейчас находятся на каникулах (status = ‘vacation’).</p>
                    </td> 
                    <td class="col-md-6">
                        <code>
                            SELECT student.name, student.surname FROM student 
                            INNER JOIN 
                            (SELECT student_status.student_id
                            FROM (SELECT student_id, MAX(datetime) AS last_date FROM student_status GROUP BY student_id) AS student_last_date
                            INNER JOIN student_status
                            ON student_status.student_id=student_last_date.student_id AND student_status.datetime=student_last_date.last_date
                            WHERE student_status.status='vacation' 
                            ) AS vacation_student
                            WHERE student.gender='unknown' AND student.id=vacation_student.student_id
                        </code>
                    </td>                    
                </tr>
                
                <tr>
                    <td class="col-md-6">
                        Используя три предыдущие таблицы, найти имена и фамилии всех студентов, которые заплатили не больше трех раз и перестали учиться (status = ‘lost’). Нулевые платежи (amount = 0) не учитывать.
                    </td>
                    <td class="col-md-6">
                        <code>
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
                        </code>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>
