<?php
namespace App\Services;

use Illuminate\Support\Facades\Validator;
use App\Exceptions\ValidateException;

class ValidatorService {

  /**
   * Validate fields from request.
   *
   * @param  array $fields
   * @param  array $validatorRules
   * @return void
   */
  public function validateFields(array $fields, array $validatorRules)
  {
    try {
      // Validate fields.
      $validator = Validator::make($fields, $validatorRules);

      // If validation fails
      // Return error messages and exit.
      if ($validator->fails()) {
        throw (new ValidateException(
          $validator->errors()
        ));
      }
    } catch (\Exception $e) {
      throw ($e);
    }
  }

}
