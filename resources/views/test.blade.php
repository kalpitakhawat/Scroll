<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <h5>Check Focus</h5>
  </body>
  <script type="text/javascript">
    var nCounter = 0;

  // Set up event handler to produce text for the window focus event
    window.addEventListener("focus", function(event)
    {
      nCounter = nCounter + 1;
      console.log('focus');
    }, false);

    window.addEventListener("blur", function(event)
    {
      nCounter = nCounter + 1;
      console.log('blur');
    }, false);
  </script>
</html>
