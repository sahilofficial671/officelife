<?php

namespace App\Models\Company;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Timesheet extends Model
{
    use LogsActivity;

    /**
     * Possible status of a timesheet.
     */
    const OPEN = 'open';
    const READY_TO_SUBMIT = 'ready_to_submit';
    const APPROVED = 'approved';
    const REJECTED = 'rejected';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_id',
        'employee_id',
        'started_at',
        'ended_at',
        'status',
        'approved_at',
        'approver_id',
    ];

    /**
     * The attributes that are logged when changed.
     *
     * @var array
     */
    protected static $logAttributes = [
        'status',
        'title',
        'amount',
        'currency',
        'description',
        'expense_date',
    ];

    /**
     * The attributes that should be changed.
     *
     * @var array
     */
    protected $casts = [
        'employee_id' => 'integer',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'expensed_at',
        'manager_approver_approved_at',
        'accounting_approver_approved_at',
        'converted_at',
    ];

    /**
     * Get the company record associated with the expense.
     *
     * @return BelongsTo
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Get the employee record associated with the expense.
     *
     * @return BelongsTo
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * Get the expense category record associated with the expense.
     *
     * @return BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(ExpenseCategory::class, 'expense_category_id');
    }

    /**
     * Get the manager record associated with the expense.
     *
     * @return BelongsTo
     */
    public function managerApprover()
    {
        return $this->belongsTo(Employee::class, 'manager_approver_id');
    }

    /**
     * Get the person in accounting who has approved the expense record
     * associated with the expense.
     *
     * @return BelongsTo
     */
    public function accountingApprover()
    {
        return $this->belongsTo(Employee::class, 'accounting_approver_id');
    }
}
