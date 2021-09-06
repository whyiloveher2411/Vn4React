<section class="ftco-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="wrapper">
                    <div class="row no-gutters">
                        <div class="col-md-7 d-flex align-items-stretch">
                            <div class="contact-wrap w-100 p-md-5 p-4">
                                <h3 class="mb-4">{!!$data['heading-left']!!}</h3>
                                <form method="POST" id="contactForm" name="contactForm" class="contactForm">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="name" id="name"
                                                    placeholder="Name">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <input type="email" class="form-control" name="email" id="email"
                                                    placeholder="Email">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="subject" id="subject"
                                                    placeholder="Subject">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <textarea name="message" class="form-control" id="message" cols="30"
                                                    rows="7" placeholder="Message"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <input type="submit" value="Send Message" class="btn btn-primary">
                                                <div class="submitting"></div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-5 d-flex align-items-stretch">
                            <div class="info-wrap bg-darken w-100 p-lg-5 p-4">
                                <h3 class="mb-4 mt-md-4">{!!$data['heading-right']!!}</h3>
                                @forif( $data['contact_channels'] as $channel)
                                <div class="dbox w-100 d-flex align-items-center">
                                    <div class="icon d-flex align-items-center justify-content-center">
                                        <span class="{!!$channel['icon']!!}"></span>
                                    </div>
                                    <div class="text pl-3">
                                        <p><span>{!!$channel['title']!!}:</span> {!!$channel['content']!!}
                                        </p>
                                    </div>
                                </div>
                                @endforif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 mt-5">
                <div id="map" class="bg-white" data-map="{!!$data['iframe-map']!!}">
                </div>
            </div>
        </div>
    </div>
</section>


<?php
    add_action('vn4_footer',function(){
        ?>

        <script>
            window.addEventListener("load", ()=>{
                setTimeout(() => {
                    
                    document.getElementById('map').innerHTML = '<iframe src="'+document.getElementById('map').getAttribute('data-map')+'" style="width:100%;border: none;" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>'
                }, 100);
            });
        </script>
        <?php
    });
?>
