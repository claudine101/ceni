<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<!DOCTYPE html>
<html >
    
<head>
  <title>VOTE || Login</title>
  <link rel="icon" type="image/jpg" href="<?=base_url()?>upload/logos.png"/>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">

 <link rel="stylesheet" href="<?=base_url()?>dist/css/login_css.css">
</head>

<style type="text/css">
  #erro_msg{
     width: 150px;
     height: 20px;
     margin: 10px;

  }
</style>
<!--Coded with love by Mutiullah Samim-->
<body style="background-image: url(<?=base_url()?>upload/Artboards.png?>); ">
  <div class="container-fluid h-100">
    <div class="d-flex justify-content-center h-100">
      <div class="user_card" style="
      
      height: 400px;
						width: 350px;
						margin-top: auto;
						margin-bottom: auto;
						background: #cacfe9;
						position: relative;
						display: flex;
						justify-content: center;
						flex-direction: column;
						padding: 10px;
						box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
						-webkit-box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
						-moz-box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
						border-radius: 5px;
      ">
        <div class="d-flex justify-content-center h-100">
          <div class="brand_logo_container">
            <img src="<?=base_url()?>upload/logos.png" class="brand_logo" alt=".">
          </div>
        </div>
        <div class="d-flex justify-content-center form_container">
          <form method="POST" id="myFom"action="<?=base_url()?>index.php/Login/do_login">
            <?=$message?>
            <div class="input-group mb-3">
              <div class="input-group-append">
                <span class="input-group-text" style="background: #434d8b !important;
						color: white !important;
						border: 0 !important;
						border-radius: 0.25rem 0 0 0.25rem !important;"><i class="fas fa-user"></i></span>
              </div>

              <input type="text" name="USERNAME" id="USERNAME" class="form-control input_user" value="" placeholder="Nom d'utilisateur" required="required" style="font-size: 13px">
            </div>
            <div class="input-group mb-2">
              <div class="input-group-append">
                <span class="input-group-text" style="background: #434d8b !important;
						color: white !important;
						border: 0 !important;
						border-radius: 0.25rem 0 0 0.25rem !important;"><i class="fas fa-key"></i></span>
              </div>
              <input type="password" name="PASSWORD" id="PASSWORD"  placeholder="Mot de passe" required="required" class="form-control input_pass" style="font-size: 13px">
            </div>
            <div class="form-group">
              <div class="custom-control custom-checkbox">
                
              </div>
            </div>
              <div class="d-flex justify-content-center mt-3 login_container">
          <button type="" name="button" class="btn login_btn " style="
          width: 100%;
						background: #434d8b !important;
						color: white !important
            " onclick="sumbmitForm()">Connexion</button>
           </div>
          </form>
        </div>
    
        <div class="mt-4">
          <div class="d-flex justify-content-center links">
          <a href="#" class="ml-2"></a>
          </div>
          <div class="d-flex justify-content-center links">
            <a href="#" style="color: #fff;font-size: 12px">Mot de passe oublier ?</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>



<script type="text/javascript">
  $('#erro_msg').delay(2000).hide('slow');

  function sumbmitForm() {

    if ($('#USERNAME').val()=='') {
       $('#USERNAME').focus();
    }else if ($('#PASSWORD').val()=='') {
       $('#PASSWORD').focus();
    }else{
      myFom.submit();
    }
   
   
}
</script>