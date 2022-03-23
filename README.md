
## About Project(School Project)


- I Make two curd (schools,students)
- I used  migration, factory, seed, soft delete
- on create new student auto generate student order number by school

- Create command to fix order number if it is messed up (for example one user was deleted)
    using this command php artisan order:reorder-students
- fire an event called (StudentsOrdered) to send email when command finish using mailtrap
- I used sanctum package to secure the apis of students and schools and must login first to acces apis
- There is also auth controller to login and register 
- I aslo made unit test to test all apis



 