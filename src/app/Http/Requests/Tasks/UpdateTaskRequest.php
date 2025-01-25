<?php

namespace App\Http\Requests\Tasks;

use App\Enums\TaskStatus;
use App\Traits\FailedValidationForApi;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTaskRequest extends FormRequest
{
    use FailedValidationForApi;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $requiredParam = $this->method() === 'PUT' ? 'required' : 'sometimes';
        
        return [
            'name' => [$requiredParam, 'max:100'],
            'description' => [$requiredParam, 'max:255'],
            'status' => ['sometimes', Rule::enum(TaskStatus::class)],
        ];
    }
}
