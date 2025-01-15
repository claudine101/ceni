


    <!-- footer start -->
    <footer class="main-footer" style="background-color: #e2e3dc"  >
        <div class="container">
        <br><br><br><br>

            <div class="row justify-content-center mb-5">
            <br><br><br><br>
                <div class="col-lg-7 col-md-12 col-sm-12 mb-2">
                    <img alt="Commissariat Général des Migrations Logo" style="margin-bottom: 10px" width='150' src='<?=base_url()?>assets/img/Logo-CENI.png'>
                    <p class="text-black">La Commission Electorale Nationale Indépendante comprend sept(7) membres: le Président, la Vice-président et 5 Commissaires chargés respectivement:

Commissaire chargé de l’Administration et des Finances;
Commissaire chargé des Affaires Juridiques et du Contentieux Électoral;
Commissaire chargé de l’Éducation Électorale et de la Communication
Commissaire chargé des Opérations de l’Informatique Électorale et de la Maintenance des Équipements;
Commissaire chargé de la logistique Électorale et des Approvisionnements..</p>

                    <div class="social-media-button">
                        <a href="#"><i style="color: #081536" class="fa fa-facebook"></i></a>
                        <a href="#"><i style="color: #081536" class="fa fa-twitter"></i></a>
                        <a href="#"><i style="color: #081536" class="fa fa-linkedin"></i></a>
                    </div><br>
                </div>

            
                <div class="col-lg-5 col-md-12 col-sm-12 mb-2 d-flex justify-content-center" style="max-width: 3400px; height: 200px">
                <ul>
        <li>Contactez-nous</li>

        <li>
            <div class="social-media-button">
                <a href="#"><i style="color: #081536" class="fa fa-envelope"></i></a>
                info@ceniburundi.bi
            </div><br>
        </li>
        <li>
            <div class="social-media-button">
                <a href="#"><i style="color: #081536" class="fa fa-phone"></i></a>
                (+257) 22 27 44 64
            </div>
        </li><br>

        <li>
            <div class="social-media-button">
                <a href="#"><i style="color: #081536" class="fa fa-map-marker"></i></a>
                Ngagara, Quartier Industriel, Blv de l’OUA, RUE NYANKONI
            </div>
        </li><br>
        
    </ul>
                    
            </div><br><br><br><br>
            <div class="col-lg-12 text-center">
                <span class="text-black">Copyright &copy; <script>
                        document.write(new Date().getFullYear())

                    </script> - Développé par <a style="text-decoration: none; color: black" href="mediabox.bi"><b>Claudine NDAYISABA</b> <img alt="Mediabox Logo" width="30px" src="<?=base_url()?>assets/img/coco.png"></a></span>
            </div>
        </div>
    </footer>
    <!-- footer end -->




    <script type="text/javascript">
    function save() {

      var statut = true;


      if ($("#id_type_plainte").val()=='') 
      {
        $('#erid_type_plainte').text('Champ obligatoire');
        $("#id_type_plainte").focus();
        statut = false;
        console.log(statut)
      }

     
        
      if ($("#email_internaute").val()=='') 
      {
        $('#eremail_internaute').text('Champ obligatoire');
        $("#email_internaute").focus();
        statut = false;
        console.log(statut)
      }

      if ($("#telephone_internaute").val()=='') 
      {
        $('#ertelephone_internaute').text('Champ obligatoire');
        $("#telephone_internaute").focus();
        statut = false;
        console.log(statut)
      }

      if ($("#message").val()=='') 
      {
        $('#ermessage').text('Champ obligatoire');
        $("#message").focus();
        statut = false;
        console.log(statut)
      }

      if (statut==true)
       { 
          myformmessage.submit();
       }
    }
</script>

   
    <script type="text/javascript">
      jQuery(document).ready(function($) {
  var alterClass = function() {
    var ww = document.body.clientWidth;
    if (ww > 440) {
      $('.dropdown-item').removeClass('text-wrap');
    } else if (ww <= 441) {
      $('.dropdown-item').addClass('text-wrap');
    };
  };
  $(window).resize(function(){
    alterClass();
  });
  //Fire it when the page first loads:
  alterClass();
});
    </script>




