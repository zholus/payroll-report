# Payroll report application
Generate and see report in CLI!

# How to run

## Install via docker-compose
- `docker-compose build`
- `docker-compose up -d`
- `docker-compose exec payroll_php composer build:dev`

## Add some departments and employees
```sql
INSERT INTO payroll.departments (id, name, additional_salary_type, additional_salary_value) VALUES ('59e2be6e-27f4-43db-9a81-876ada707a3b', 'HR', 'percentage', 1000);
INSERT INTO payroll.departments (id, name, additional_salary_type, additional_salary_value) VALUES ('ff625a44-cccf-4a5c-a608-a5f0b4521727', 'IT', 'fixed', 10000);
INSERT INTO payroll.employees (id, department_id, first_name, last_name, salary, employed_at) VALUES ('072ad20f-c78d-4bf5-acb6-4bbf20761fc9', '59e2be6e-27f4-43db-9a81-876ada707a3b', 'Bruce', 'Wayne', 110000, '2016-03-09 23:36:28');
INSERT INTO payroll.employees (id, department_id, first_name, last_name, salary, employed_at) VALUES ('3e626bc1-362d-4084-af98-3a763281f0fd', 'ff625a44-cccf-4a5c-a608-a5f0b4521727', 'Peter', 'Parker', 67541, '2020-06-10 21:47:20');
INSERT INTO payroll.employees (id, department_id, first_name, last_name, salary, employed_at) VALUES ('58cd309b-9d1f-4663-90fc-09ede7a4e5f1', '59e2be6e-27f4-43db-9a81-876ada707a3b', 'Grzegorz', 'Brzęczyszczykiewicz', 6545234, '2018-02-10 21:48:46');
INSERT INTO payroll.employees (id, department_id, first_name, last_name, salary, employed_at) VALUES ('75f0b2f1-d230-4eaf-b6f0-26fabefd2289', 'ff625a44-cccf-4a5c-a608-a5f0b4521727', 'Barry', 'Allen', 848239, '2018-08-11 22:55:06');
INSERT INTO payroll.employees (id, department_id, first_name, last_name, salary, employed_at) VALUES ('ff77bb7f-6a1b-4b89-8c54-3547c94d06c8', 'ff625a44-cccf-4a5c-a608-a5f0b4521727', 'Clark', 'Kent', 100000, '2004-08-09 22:52:18');
```
## Generate report
`docker-compose exec payroll_php bin/console payroll:report:generate`

In response you'll receive report id

## Show report
`docker-compose exec payroll_php bin/console payroll:report:show <id>`

use `bin/console payroll:report:show --help` for more information.

### Sort report
`docker-compose exec payroll_php bin/console payroll:report:show <id> --sort-field=<field name> --sort-direction=<direction>`

### Filter report
`docker-compose exec payroll_php bin/console payroll:report:show <id> --filter-field=<field name> --filter-value=<value>`


# Run tests

`docker-compose exec payroll_php composer tests`
