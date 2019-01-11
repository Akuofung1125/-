<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB"
    crossorigin="anonymous">

  <title>電子化流程設計與管理</title>
</head>

<body>

<?php
require_once(__DIR__ . "/config.php");
ini_set ("soap.wsdl_cache_enabled", "0");
$client = new SoapClient($conf['EasyFlowServer']);

if($_POST){
    if(
        !empty($_POST['oid'])
        && !empty($_POST['uid'])
        && !empty($_POST['eid'])
    ) {

        // 參數設定
        $oid = $_POST['oid']; //Date9    --3
        $uid = $_POST['uid']; //Textbox5 --2
        $eid = $_POST['eid']; //Textbox4 --1
        $msg = $_POST['msg']; //Date11
        $msg1 = $_POST['msg1']; //Time10
        $msg2 = $_POST['msg2']; // Date14
        $msg3 = $_POST['msg3'];  //Time13
        $apply = $_POST['apply'];// Dropdown22
        $help = $_POST['help'];  //Dropdown25
        $num = $_POST['num']; //Textbox23
        $add = $_POST['add']; //TextArea18
        $applychar = $_POST['applychar']; //textbox4
        $applyman = $_POST['applyman'];   //textbox5
        $applydate = $_POST['applydate']; //Date9
       

        // 送到流程管理
        try{
            $procesesStr = $client->findFormOIDsOfProcess($oid);

            $proceses = explode(",", $procesesStr);
            $process = $proceses[0];
            $template = $client->getFormFieldTemplate($process);

            $form = simplexml_load_string($template);

            $form->Date9 = $applydate;
            $form->Textbox5 = $applyman;
            $form->Textbox4 = $applychar;
            $form->Date11 = $msg;
            $form->Time10 = $msg1;
            $form->Date14 = $msg2;
            $form->Time13 = $msg3;
            $form->Dropdown22 = $apply;
            $form->Dropdown25 = $help;
            $form->Textbox23 = $num;
            $form->TextArea18 = $add;

            $result = $form->asXML();
            $client->invokeProcess($oid, $eid, $uid, $process, $result, "伺服器代管申請作業");
        }catch(Exception $e){
        echo $e->getMessage();
        }

    } else {
        echo "系統錯誤";
    }
    
}

?>

  <div class="container">
    <div class="py-5 text-center">
      <h2>電子化流程設計與管理</h2>
    </div>

    <div class="row">

      <div class="col-md-12 order-md-1">
        <h4 class="mb-3"></h4>
        <form class="needs-validation" method="POST" action="./index.php">
          <div class="row">
            <div class="col-md-12 mb-3">
              <label for="eid">員工編號</label>
              <input name="eid" type="text" class="form-control" id="eid" placeholder="" value="" required>
              <div class="invalid-feedback">
                員工編號 必填
              </div>
            </div>
          </div>

          <div class="row">
              <div class="col-md-12 mb-3">
                  <label for="uid">員工單位編號</label>
                  <input name="uid" type="text" class="form-control" id="uid" placeholder="" value="" required>
                  <div class="invalid-feedback">
                  員工單位標號 必填
                  </div>
                </div>
          </div>

          <div class="row">
              <div class="col-md-12 mb-3">
                  <label for="oid">流程編號</label>
                  <input name="oid" type="text" class="form-control" id="oid" placeholder="" value="" required>
                  <div class="invalid-feedback">
                    流程編號 必填
                  </div>
                </div>
          </div>

          <div class="row">
              <div class="col-md-12 mb-3">
                  <label for="applychar">申請單位</label>
                  <input name="applychar" type="text" class="form-control" id="applychar" placeholder="" value="" required>
                  <div class="invalid-feedback">
                    申請單位 必填
                  </div>
                </div>
          </div>

          <div class="row">
              <div class="col-md-12 mb-3">
                  <label for="applyman">申請人/分機</label>
                  <input name="applyman" type="text" class="form-control" id="applyman" placeholder="" value="" required>
                  <div class="invalid-feedback">
                    申請人/分機 必填
                  </div>
                </div>
          </div>

          <div class="row">
              <div class="col-md-12 mb-3">
                  <label for="applydate">申請日期</label>
                  <input name="applydate" type="date" class="form-control" id="applydate" placeholder="" value="" required>
                  <div class="invalid-feedback">
                    申請日期 必填
                  </div>
                </div>
          </div>
              
          <div class="row">
              <div class="col-md-6 mb-3">
                  <label for="msg">刊登時間</label>
                  <input name="msg" type="date" class="form-control" id="msg" placeholder="" value="" required>
                  <input name="msg1" type="time" class="form-control" id="msg" placeholder="" value="" required>
                  <div class="invalid-feedback">
                    刊登時間 必填
                  </div>
                  
                  </div>
                  <div class="col-md-6 mb-3">
                  <label for="msg">刊登時間</label>
                  <input name="msg2" type="date" class="form-control" id="msg" placeholder="" value="" required>
                  <input name="msg3" type="time" class="form-control" id="msg" placeholder="" value="" required>
                  <div class="invalid-feedback">
                    刊登時間 必填
                  </div>
                  </div>
                  
          
          </div>

          <div class="row">
              <div class="col-md-12 mb-3">
                  <label for="msg">目的</label>
                  <input name="num" type="text" class="form-control" id="num" placeholder="" value="" required>
                  <div class="invalid-feedback">
                    目的 必填
                  </div>
                </div>
          </div>

          <div class="row">
              <div class="col-md-4 mb-3">
                  <label for="apply">申請事項</label><br>
                  <input type="radio" name="apply" value="1"> Banner<br>
                  <input type="radio" name="apply" value="2"> 跑馬燈<br>
                  <input type="radio" name="apply" value="3"> 快速連結<br>
                  <input type="radio" name="apply" value="4"> 網頁內容<br>
                  <input type="radio" name="apply" value="5"> 網頁版面<br>
                  <input type="radio" name="apply" value="6"> 增建帳號<br>
                  <input type="radio" name="apply" value="7"> 其他<br>
                  
                  </div>
                  <div class="col-md-4 mb-3">
                  <label for="help">協助事項</label><br>
                  <input type="radio" name="help" value="8"> 新增<br>
                  <input type="radio" name="help" value="9"> 修改<br>
                  <input type="radio" name="help" value="10"> 刪除<br>
                  
                  </div>
                  <div class="col-md-4 mb-3">
                  <label for="add">申請事項說明</label><br>
                  <textarea name="add" class="form-control" id="add" placeholder="" value="" required></textarea>
                  
                  </div>
                  
          
          </div>


          <hr class="mb-4">
          <button class="btn btn-primary btn-lg btn-block" type="submit">送出</button>
        </form>
      </div>
    </div>

    <footer class="my-5 pt-5 text-muted text-center text-small">
      <p class="mb-1">&copy; 2017-2018 NKUST MIS</p>
    </footer>
  </div>

  <!-- Bootstrap core JavaScript
        ================================================== -->
  <!-- Placed at the end of the document so the pages load faster -->
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
    crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
    crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
    crossorigin="anonymous"></script>
  <script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function () {
      'use strict';

      window.addEventListener('load', function () {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.getElementsByClassName('needs-validation');

        // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function (form) {
          form.addEventListener('submit', function (event) {
            if (form.checkValidity() === false) {
              event.preventDefault();
              event.stopPropagation();
            }
            form.classList.add('was-validated');
          }, false);
        });
      }, false);
    })();
  </script>
</body>

</html>