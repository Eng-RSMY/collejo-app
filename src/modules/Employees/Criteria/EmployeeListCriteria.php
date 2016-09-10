<?php

namespace Collejo\App\Modules\Employees\Criteria;

use Collejo\Core\Foundation\Repository\BaseCriteria;
use DB;
use Collejo\App\Models\Employee;
use Collejo\Core\Contracts\Repository\EmployeeRepository;

class EmployeeListCriteria extends BaseCriteria{

	protected $model = Employee::class;

	protected $criteria = [
			['employee_department_id', '=', 'employee_department'],
			['employee_number', '%LIKE%'],
			['name', '%LIKE%'],
		];

	protected $selects = [
			'name' => 'CONCAT(users.first_name, \' \', users.last_name)'
		];

	protected $joins = [
			['users', 'employees.user_id', 'users.id']
		];

	protected $form = [
			'employee_department' => [
				'type' => 'select',
				'itemsCallback' => 'employeeDepartments'
			]
		];

	public function callbackEmployeeDepartments()
	{
		return app()->make(EmployeeRepository::class)->getEmployeeDepartments()->get();
	}
}