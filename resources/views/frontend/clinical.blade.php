@include('frontend/header')

<!-- <iframe class="common_header" src="../pages/header.html"></iframe> -->

<section class="clinicial-services">
    <div class="container">
        <div class="top-header">
            <h3>Clinicial Services</h3>
        </div>

        @foreach ($clinicaldata as $data)
            <div class="nurse_visit">
                <div class="nurse_visit_inner">
                    <div class="left_img">
                        <img src="{{ $data->image }}">
                    </div>
                    <div class="center_text">
                        <h3>{{ $data->head }}</h3>
                        <h3>£{{ $data->price }}</h3>
                        <p>{{ $data->para }}</p>
                        <a href="#">More info</a>
                    </div>
                    <div class="right_button">
                        <button class="button" onclick="addTocart('{{ $data->id }}')">Add</button>

                    </div>
                </div>
            </div>
        @endforeach

        <div class="clinicial_services_bottom">
            <button type="button">Continue with Hormone & Fertility Test only</button>
        </div>

    </div>
</section>


<script>
    function addTocart(id) {
        var csrfToken = '{{ csrf_token() }}';
        var url = '/add_to_cart'
        var data = {
            id: id,
            _token: csrfToken
        };
         $.ajax({
            type: 'POST',
            url: url,
            data: data,
            success: function(result) {
                $('#cartCount').addClass('cart_style');
                $('#cartCount').text(result.count);
            }
        });
    }
</script>
</body>

</html>
