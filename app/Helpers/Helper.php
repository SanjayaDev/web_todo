<?php

if (!function_exists("create_response")) {
  function create_response()
  {
    $response = new stdClass;
    $response->status = FALSE;
    $response->status_code = 404;
    $response->data = [];
    $response->message = "Not Found";

    return $response;
  }
}

if (!function_exists("response_success_default")) {
  function response_success_default($message, $id = FALSE, $next_url = FALSE)
  {
    $response = create_response();
    $response->status = TRUE;
    $response->status_code = 200;
    if ($id) {
      $response->data = [
        "id" => $id
      ];
    }

    $response->message = $message;
    if ($next_url) {
      $response->next_url = $next_url;
    }

    return $response;
  }
}

if (!function_exists("response_errors_default")) {
  function response_errors_default()
  {
    $response = new stdClass;
    $response->status = FALSE;
    $response->status_code = 500;
    $response->data = [];
    $response->message = "Terjadi kesalahan server!";

    return $response;
  }
}

if (!function_exists("response_json")) {
  function response_json($response) {
    return response()->json($response, $response->status_code);
  }
}

if (!function_exists("response_data")) {
  function response_data($data) {
    $response = create_response();

    if (count($data) > 0) {
      $response->status = TRUE;
      $response->status_code = 200;
      $response->message = "Found!";
      $response->data = $data;
    }

    return $response;
  }
}

if (!function_exists("random_string")) {
  function random_string($length = 10) {
    return \Illuminate\Support\Str::random($length);
  }
}

if (!function_exists("form_delete")) {
  function form_delete($formID, $route, $class = "d-block", $btn = "btn-danger", $prompt_message = "Yakin ingin menghapus data ini?", $button_title = "Hapus", $method = "DELETE") {
    $html = "<form id='$formID' action='$route' class='$class' method='POST' with-submit-crud>";
      $html .= "<input type='hidden' name='_token' value='".csrf_token()."'>";
      $html .= "<input type='hidden' name='_method' value='$method'>";

      $html .= "<button class='btn $btn btn-sm' type='button' onclick=\"CORE.promptForm('$formID', '$prompt_message')\">$button_title</button>";
    $html .= "</form>";

    return $html;
  }
}

if (!function_exists("form_get")) {
  function form_get($formID, $route, $class = "d-block", $btn = "btn-primary", $prompt_message = "Yakin ingin mengambil data ini?", $button_title = "Ambil") {
    $html = "<form id='$formID' action='$route' class='$class' with-submit-crud>";

      $html .= "<button class='btn $btn btn-sm' type='button' onclick=\"CORE.promptForm('$formID', '$prompt_message')\">$button_title</button>";
    $html .= "</form>";

    return $html;
  }
}

if (!function_exists("insert_log")) {
  function insert_log(\Exception $e, $message) {
    \info($message, [
      "message" => $e->getMessage(),
      "trace" => $e->getTraceAsString()
    ]);
  }
}

if (!function_exists("delete_comma")) {
  function delete_comma($string) {
    return str_replace(",", "", $string);
  }
}

if (!function_exists("delete_decimal")) {
  function delete_decimal($string) {
    if (strlen($string) > 3) {
      return substr($string, 0, strlen($string) - 3);
    }

    return $string;
  }
}


if (!function_exists("is_role")) {
  function is_role($role_name, $user_id = FALSE) {
    if ($user_id) {
      return \App\Models\User::query()->where("id", $user_id)->first()->role?->role_name == $role_name;
    }
    // dd(auth()->user()->role->role_name);
    return auth()->user()->role?->role_name == $role_name;
  }
}

if (!function_exists("is_email")) {
  function is_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
  }
}

if (!function_exists("check_authorized")) {
  function check_authorized($module_code)
  {
    return (new \App\Services\AuthorizationService)->check_authorization($module_code);
  }
}