<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/add-ons.css">
    <link rel="stylesheet" type="text/css" href="../css/payment.css">
    <link rel="stylesheet" type="text/css" href="../css/cart.css">
    <link rel="stylesheet" type="text/css" href="../css/header.css">
    <link rel="stylesheet" type="text/css" href="../css/login.css">
    <link rel="stylesheet" type="text/css" href="../css/account.css">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link rel="stylesheet" type="text/css" href="../css/test.css">
    <link rel="stylesheet" type="text/css" href="../css/delivery.css">
    <link rel="stylesheet" type="text/css" href="../css/order.css">
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
    <title>Your Test</title>
</head>

<body>

    <header class="new_header">
        <div class="container_new">
            <a href="{{ url('/') }}">
                <div class="header_logo">
                    <img src="../images/Logo-white.svg">
                </div>
            </a>
            <div class="header_nav">
                @if (Session::has('userData'))
                @else
                    <div class="nav_item_new">
                        <a href="#">Test</a>
                    </div>
                    <div class="nav_item_new">
                        <a href="{{ url('/login') }}">Login</a>
                    </div>
                    <div class="nav_item_new">
                        <a href="{{ '/register' }}">Sign up</a>
                    </div>
                @endif


                <div class="nav_item_new dropdown">
                    <button class="dropbtn"><svg width="20" height="20" version="1.1" fill="white"
                            id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                            x="0px" y="0px" viewBox="0 0 285.5 285.5"
                            style="color:#fff; enable-background:new 0 0 285.5 285.5;" xml:space="preserve">
                            <g id="XMLID_791_">
                                <path stroke="white" id="XMLID_792_"
                                    d="M142.75,125.5c34.601,0,62.751-28.149,62.751-62.75S177.351,0,142.75,0S79.999,28.149,79.999,62.75
								S108.149,125.5,142.75,125.5z M142.75,30c18.059,0,32.751,14.691,32.751,32.75S160.809,95.5,142.75,95.5
								s-32.751-14.691-32.751-32.75S124.691,30,142.75,30z" />
                                <path id="XMLID_795_"
                                    d="M142.75,155.5c-63.411,0-115,51.589-115,115c0,8.284,6.716,15,15,15h200c8.284,0,15-6.716,15-15
								C257.75,207.089,206.161,155.5,142.75,155.5z M59.075,255.5c7.106-39.739,41.923-70,83.675-70s76.569,30.261,83.675,70H59.075z" />
                        </svg>Account</button>
                    <div class="dropdown-content">
                        <a href="#">Test</a>
                        <a href="{{ url('/order') }}">Order</a>
                        @if (Session::has('userData'))
                            <a href="{{ url('/logout') }}">Logout</a>
                        @else
                        @endif
                    </div>
                </div>
                <div class="nav_item_new">
                    <a href="{{ url('/cart') }}"><svg width="24" height="26" viewBox="0 0 24 26" fill="#fff"
                            stroke="2" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M20 6.01752H15.0865V4.06267C15.0923 3.53123 14.991 3.00392 14.7882 2.51128C14.5855 2.01863 14.2855 1.57043 13.9056 1.1926C13.5256 0.814769 13.0733 0.514821 12.5747 0.310113C12.0761 0.105404 11.5412 0 11.0009 0C10.4607 0 9.9258 0.105404 9.42722 0.310113C8.92864 0.514821 8.47629 0.814769 8.09633 1.1926C7.71637 1.57043 7.41636 2.01863 7.21365 2.51128C7.01094 3.00392 6.90957 3.53123 6.91539 4.06267V6.01752H2V22H20V6.01752ZM7.97799 4.06267C7.97298 3.66901 8.04746 3.27829 8.19713 2.91317C8.3468 2.54804 8.56867 2.21579 8.84988 1.93567C9.13108 1.65555 9.46603 1.43314 9.83528 1.28134C10.2045 1.12954 10.6008 1.05138 11.0009 1.05138C11.4011 1.05138 11.7974 1.12954 12.1666 1.28134C12.5359 1.43314 12.8708 1.65555 13.152 1.93567C13.4332 2.21579 13.6551 2.54804 13.8048 2.91317C13.9544 3.27829 14.0289 3.66901 14.0239 4.06267V6.01752H7.97799V4.06267ZM15.0865 7.06237H18.9369V20.9551H3.0626V7.06237H15.0865Z">
                            </path>
                        </svg>
                        @if (Session::has('userData'))
                            @if ($itemCount > 0)
                                <span class="cart_style">{{ $itemCount }}</span>
                            @endif
                        @endif

                    </a>
                </div>
            </div>
        </div>
    </header>

    <div class="wrapper">
        <div class="header_bottom">
            <div class="your_test">

                <div class="test_inner">
                    <a href="{{ url('/') }}" class="test_step active">
                        <span class="test_tube_hold"><svg class="test_tube" height="25" width="25" fill="#fff"
                                version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
                                <g>
                                    <g>
                                        <path fill="#fff"
                                            d="M386.554,0c-14.857,0-252.556,0-261.106,0c-11.321,0-20.499,9.178-20.499,20.499c0,11.321,9.178,20.499,20.499,20.499
			h18.493c0,16.456,0,345.098,0,358.929C143.94,461.723,194.21,512,256,512s112.06-50.277,112.06-112.073
			c0-17.32,0-345.896,0-358.929h18.493c11.321,0,20.499-9.178,20.499-20.499C407.053,9.178,397.875,0,386.554,0z M327.064,251.898
			c-47.039,0-50.564,1.495-50.564-4.783c0-25.249-20.542-45.781-45.781-45.781h-45.781V40.997h142.125V251.898z" />
                                    </g>
                                </g>
                            </svg></span>
                        <p>Your test</p>
                    </a>

                    <a href="{{ url('/addons') }}" class="test_step">
                        <span class="test_tube_hold"><svg height="25" width="25" version="1.1"
                                id="Icons" xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                viewBox="0 0 32 32" style="enable-background:new 0 0 32 32;" xml:space="preserve">
                                <style type="text/css">
                                    .st0 {
                                        fill: none;
                                        stroke: #fff;
                                        stroke-width: 2;
                                        stroke-linecap: round;
                                        stroke-linejoin: round;
                                        stroke-miterlimit: 10;
                                    }

                                    .st1 {
                                        fill: none;
                                        stroke: #fff;
                                        stroke-width: 2;
                                        stroke-linecap: round;
                                        stroke-linejoin: round;
                                        stroke-miterlimit: 10;
                                        stroke-dasharray: 3;
                                    }

                                    .st2 {
                                        fill: none;
                                        stroke: #fff;
                                        stroke-width: 2;
                                        stroke-linejoin: round;
                                        stroke-miterlimit: 10;
                                    }

                                    .st3 {
                                        fill: none;
                                    }
                                </style>
                                <path class="st0"
                                    d="M3,14h8l3.4-7.9c0.3-0.7,1-1.1,1.8-1.1h7.1c0.7,0,1.2,0.8,0.9,1.4L21,14" />
                                <line class="st0" x1="11" y1="14" x2="29" y2="14" />
                                <path class="st0"
                                    d="M22.4,27H9.6c-1.5,0-2.7-1.1-3-2.5L5,14h22l-1.6,10.5C25.2,25.9,23.9,27,22.4,27z" />
                                <line class="st0" x1="16" y1="17" x2="16" y2="23" />
                                <line class="st0" x1="13" y1="20" x2="19" y2="20" />
                                <rect x="-144" y="-72" class="st3" width="536" height="680" />
                            </svg>
                        </span>
                        <p>Add-ons</p>
                    </a>

                    <a href="{{ url('/cart') }}" class="test_step">
                        <span class="test_tube_hold"><svg width="24" height="26" viewBox="0 0 24 26"
                                fill="#fff" stroke="2" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M20 6.01752H15.0865V4.06267C15.0923 3.53123 14.991 3.00392 14.7882 2.51128C14.5855 2.01863 14.2855 1.57043 13.9056 1.1926C13.5256 0.814769 13.0733 0.514821 12.5747 0.310113C12.0761 0.105404 11.5412 0 11.0009 0C10.4607 0 9.9258 0.105404 9.42722 0.310113C8.92864 0.514821 8.47629 0.814769 8.09633 1.1926C7.71637 1.57043 7.41636 2.01863 7.21365 2.51128C7.01094 3.00392 6.90957 3.53123 6.91539 4.06267V6.01752H2V22H20V6.01752ZM7.97799 4.06267C7.97298 3.66901 8.04746 3.27829 8.19713 2.91317C8.3468 2.54804 8.56867 2.21579 8.84988 1.93567C9.13108 1.65555 9.46603 1.43314 9.83528 1.28134C10.2045 1.12954 10.6008 1.05138 11.0009 1.05138C11.4011 1.05138 11.7974 1.12954 12.1666 1.28134C12.5359 1.43314 12.8708 1.65555 13.152 1.93567C13.4332 2.21579 13.6551 2.54804 13.8048 2.91317C13.9544 3.27829 14.0289 3.66901 14.0239 4.06267V6.01752H7.97799V4.06267ZM15.0865 7.06237H18.9369V20.9551H3.0626V7.06237H15.0865Z">
                                </path>
                            </svg></span>
                        <p>Cart</p>
                    </a>

                    @if (Session::has('userData'))
                    @else
                        <a href="{{ url('/register') }}" class="test_step">
                            <span class="test_tube_hold"><svg height="25" width="25" fill="#fff"
                                    version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                                    xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                    viewBox="0 0 285.5 285.5" style="enable-background:new 0 0 285.5 285.5;"
                                    xml:space="preserve">
                                    <g id="XMLID_791_">
                                        <path id="XMLID_792_"
                                            d="M142.75,125.5c34.601,0,62.751-28.149,62.751-62.75S177.351,0,142.75,0S79.999,28.149,79.999,62.75
                            S108.149,125.5,142.75,125.5z M142.75,30c18.059,0,32.751,14.691,32.751,32.75S160.809,95.5,142.75,95.5
                            s-32.751-14.691-32.751-32.75S124.691,30,142.75,30z" />
                                        <path id="XMLID_795_"
                                            d="M142.75,155.5c-63.411,0-115,51.589-115,115c0,8.284,6.716,15,15,15h200c8.284,0,15-6.716,15-15
                            C257.75,207.089,206.161,155.5,142.75,155.5z M59.075,255.5c7.106-39.739,41.923-70,83.675-70s76.569,30.261,83.675,70H59.075z" />
                                    </g>
                                </svg></span>
                            <p>Account</p>
                        </a>
                    @endif

                    <a href="{{ url('/delivery') }}" class="test_step">
                        <span class="test_tube_hold"><svg height="25" width="25" fill="#fff"
                                viewBox="0 0 200 200" data-name="Layer 1" id="Layer_1"
                                xmlns="http://www.w3.org/2000/svg">
                                <title />
                                <path
                                    d="M178.25,47.38l-64-34a30.72,30.72,0,0,0-28,0l-64,34a9.44,9.44,0,0,0-5.5,9v79a19.6,19.6,0,0,0,10.5,17.49l67.5,36a10.59,10.59,0,0,0,9.5,0l68.5-36a20.19,20.19,0,0,0,10.5-17.49V55.88a9.69,9.69,0,0,0-5-8.51Zm-88,116-53-28v-63l53,28.49Zm10-80L48.75,55.88l47-25a10.59,10.59,0,0,1,9.5,0l47,25Zm63,52-53,28v-62.5l53-28Z" />
                            </svg></span>
                        <p>Delivery</p>
                    </a>

                
                        <a href="{{ url('/payment') }}" class="test_step">
                            <span class="test_tube_hold"><svg height="25" width="25" fill="#fff"
                                    viewBox="0 0 25 25" version="1.1" xmlns="http://www.w3.org/2000/svg"
                                    xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <g id="🔍-Product-Icons" stroke="none" stroke-width="1" fill="none"
                                        fill-rule="evenodd">
                                        <g id="ic_fluent_payment_24_filled" fill="#212121" fill-rule="nonzero">
                                            <path fill="#fff"
                                                d="M21.9883291,10.9947074 L21.9888849,16.275793 C21.9888849,17.7383249 20.8471803,18.9341973 19.4064072,19.0207742 L19.2388849,19.025793 L4.76104885,19.025793 C3.29851702,19.025793 2.10264457,17.8840884 2.01606765,16.4433154 L2.01104885,16.275793 L2.01032912,10.9947074 L21.9883291,10.9947074 Z M18.2529045,14.5 L15.7529045,14.5 L15.6511339,14.5068466 C15.2850584,14.556509 15.0029045,14.8703042 15.0029045,15.25 C15.0029045,15.6296958 15.2850584,15.943491 15.6511339,15.9931534 L15.7529045,16 L18.2529045,16 L18.3546751,15.9931534 C18.7207506,15.943491 19.0029045,15.6296958 19.0029045,15.25 C19.0029045,14.8703042 18.7207506,14.556509 18.3546751,14.5068466 L18.2529045,14.5 Z M19.2388849,5.0207074 C20.7014167,5.0207074 21.8972891,6.162412 21.9838661,7.60318507 L21.9888849,7.7707074 L21.9883291,9.4947074 L2.01032912,9.4947074 L2.01104885,7.7707074 C2.01104885,6.30817556 3.15275345,5.11230312 4.59352652,5.02572619 L4.76104885,5.0207074 L19.2388849,5.0207074 Z"
                                                id="🎨-Color"></path>
                                        </g>
                                    </g>
                                </svg>
                            </span>
                            <p>Payment</p>
                        </a>
                        
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            $('a.test_step')
                .click(function(e) {
                    $('a.test_step')
                        .removeClass("active");
                    $(this).addClass("active");
                });
        });
    </script>
</body>

</html>
