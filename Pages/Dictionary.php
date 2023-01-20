<h3>Söz</h3>
<input type="text">
<h3>Перевод</h3>
<input type="text">
<h3>Описание</h3>
<input type="text">
<br>
<button>Save</button>
<br>

<?php
$word = "Ahtem";
$translate = "Akhtem";
$description = "Description)";

$reqString = "INSERT INTO Words(word,translate,description)
VALUES('$word','$translate','$description')";
$result = SqlManager::$share->request($reqString);
try {
    if($result->error ?? false) { throw $result->error; }
    $data = $result->data ?? throw new Exception("Not data");
    Response::success($data);
} catch(Exception $e) {
    Console::log("Router: Error: ".$e->getMessage());
    $this->res->body = Response::failure($e);
    return;
}
?>