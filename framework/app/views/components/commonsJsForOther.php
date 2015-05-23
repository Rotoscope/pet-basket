<script type="text/javascript">
    $('#mynavbar').find('li').each(function (i, element) {
        //element.removeClass('active')
        //console.log(element)
        $(element).removeClass('active')

    })

    console.log($('#mynavbar a[href="#other"]').parent().addClass('active'))
</script>

