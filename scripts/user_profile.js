$(document).ready( function() {
  $('button#update-profile').click( function() {
    $('section#profile-update').slideDown( 'slow' );
    $(this).slideUp( 'slow' );
  });
});