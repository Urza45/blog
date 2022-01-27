$('.userinfo').click(function(){
    var userid = $(this).data('id');
    var url_dest = $(this).data('route');
    var new_title = $(this).data('title');
    // AJAX request
    $.ajax({
         url: url_dest,
         type: 'post',
         data: {userid: userid},
         success: function(response){ 
               // Add response in Modal body
               $('.modal-body').html(response);
            $('.modal-title').html(new_title);   
            // Display Modal
            $('#empModal').modal('show');
         },
        error: function(){
            $('.modal-body').html("Une erreur est survenue.");
            $('.modal-title').html('Erreur');
            // Display Modal
            $('#empModal').modal('show');
        }
   });
});

$('.close').click(function(){
    $('#empModal').modal('hide');
});

