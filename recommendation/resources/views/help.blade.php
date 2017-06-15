<script type="text/javascript" src="js/infoBox.js"></script>
<script laguage="javascript">
$(document).ready(function(){
    $('.help').infoBox({
        "width":500,
        "bg_color":"#F05F40"
    });
    $('.help1').infoBox({
        "width":500,
        "bg_color":"#F05F40"
    });
    $('.help2').infoBox({
        "width":500,
        "bg_color":"#F05F40"
    });
    $('.help3').infoBox({
        "width":500,
        "bg_color":"#F05F40"
    });
    $('#help').click(function(){
        $('.helper').show();
        $('.helper').css('z-index',9999);
    });
    $('.main-grids').click(function(){
        $('.helper').hide();
    });
});
</script>