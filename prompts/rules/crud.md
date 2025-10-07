Pada tag form, tambahkan attribute 'with-submit-crud'

Pada controller baik method store/update menggunakan validation dari class request dan hanya return response json. Contoh
$response = $this->service->store($request);
return response_json($response);

Pada method di Service, bungkus dengan db transaciton dan try catch seperti dibawah

$response = create_response();
$error = FALSE;

// Start Database Transaction
DB::beginTransaction();

// Let's start!
try  {
  // This code logic
} catch (\Exception $e) {
  $error = TRUE;
  if ($e->getCode() == 403) {
    $response->message = $e->getMessage();
    $response->status_code = 403;
  } else {
    $response = response_errors_default();
    ErrorService::error($e, "NameService::store");
  }
}

// Final check
end:
if ($error) {
  // If have error, Rollback database
  DB::rollback();
} else {
  // Success, commit database and return response success
  DB::commit();
  $response = response_success_default(message, id, route next url);
}

return $response;

Kamu bisa check function tambahan ada di app/Helpers/Helper.php