<div id="myDiv"></div>


<script type="text/javascript">
$(function() {
    $('#myDiv').floatingWhatsApp({
        phone: '+25779128128',
        message: '',
        popupMessage: 'Bonjour. Comment puis-je vous assister?',
        position: 'right',
        headerTitle: '<img width="  80px" src="<?=base_url()?>assets/img/Logo-CENI.png" />  Assistant en ligne CENI',
        showPopup: true
    });
});
</script>