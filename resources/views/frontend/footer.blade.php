<script type="text/javascript">
  $(document).ready(function () {
      $('.test_step')
              .click(function (e) {
          $('a.test_step')
              .removeClass("active");
          $(this).addClass("active");
      });
  });
</script>