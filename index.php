<?php
session_start();
$_SESSION['token'] = bin2hex(random_bytes(32));
$_SESSION['token-expire'] = time() + 3600; // 1 hour = 3600 secs

?>

<p>To receive the comic and news postings in your inbox, subscribe here.</p>
<form id="subscribeForm" method="POST" action="#">
  <input type="hidden" id="token" name="token" value="<?php echo $_SESSION['token']; ?>" />
  <input type="email" id="email" name="email" required placeholder="Enter a valid email address"/>
  <input type="submit" value="Subscribe"/>
</form>


<script src="assets/js/jquery.js" type="text/javascript"></script> 
<script src="assets/js/bootstrap.min.js" type="text/javascript"></script>
<script>
  $(document).ready(function(){
    var request;
    $("#subscribeForm").submit(function(event){
        event.preventDefault();
        if (request) {
            request.abort();
        }
        var $form = $(this);
        var $inputs = $form.find("input");
        var serializedData = $form.serialize();
        $inputs.prop("disabled", true);
        request = $.ajax({
            url: "subscribe.php",
            type: "post",
            data: serializedData
        });
        
        request.done(function (response, textStatus, jqXHR){
            console.log("Hooray, it worked!");
            if(200 == jqXHR.status) {
                $('<div class="alert alert-success ">You should receive an email shortly which will enable you to complete the subscribe process.</div>').insertBefore($form).delay(10000).fadeOut();
            } else {
                $('<div class="alert alert-dange ">Invalid request.</div>').insertBefore($form).delay(10000).fadeOut();
            }
        });

        request.fail(function (jqXHR, textStatus, errorThrown){
            console.error(
                "The following error occurred: "+
                textStatus, errorThrown
            );
            $('<div class="alert alert-dange ">Fail!</div>').insertBefore($form).delay(10000).fadeOut();
        });
        request.always(function () {
            $inputs.prop("disabled", false);
            $form.trigger("reset");
        });

    });
  });
</script>