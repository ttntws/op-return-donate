@extends('app')

@section('title', 'Decrypted op_return')
@section('description', 'Fetch all op_returns in your BTC wallet and sort them to highest first.')
@section('image', 'views/src/dist/images/social-image.png')
@section('image_width', '1012')
@section('image_height', '506')

@section('content')
    <?php 
        $grace = 60 * 60; 
        $data = setAddrData('bc1qtzny9p294xyrr8lz8vyavsjy56lucsj99j533cmhc3fp34hwn0hsqzx2dz', $grace);
    ?>
    <section class="bg-secondary hero">
        <div class="container">
            <div class="row">
                <div class="col-md-8 mx-auto text-center">
                    <h1 class="display-1 text-primary">
                        <span class="font-weight-normal">Hi crypto</span> lovers<br><span class="font-weight-normal"> and</span> programers 
                    </h1>
                    <p class="font-size-lg">I built this page for practice to improve my skills in design and frontend.</p>
                    <h2 class="h3 mt-5 mb-0">How it works?</h2>
                    <p class="font-size-lg mt-2">Send a small donation to this address – with this you can immortalize yourself in the blockchain and at this site by sending an <span class="font-weight-bold">OP_RETURN</span> in your transaction. The <span class="font-weight-bold">highest donations</span> are shown at the top.</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mx-auto my-5">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control form-copy" value="bc1qtzny9p294xyrr8lz8vyavsjy56lucsj99j533cmhc3fp34hwn0hsqzx2dz">
                        <button class="btn btn-primary btn-copy" type="button">
                            <img class="img-fluid" width="28" height="28" src="views/src/dist/images/copy-document.svg">
                        </button>
                    </div>
                </div>
            </div>
            <div class="row mb-8">
                <?php if(!empty($data['main']['count'])): ?>
                    <div class="col-12 col-sm-auto ml-md-auto mb-5 mb-sm-0">
                        <div class="card">
                            <span class="h2 mb-0 d-block"><?php echo $data['main']['count']; ?></span>
                            <span class="text-grey-light mt-n2 d-block">Transactions</span>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if(!empty($data['main']['total'])): ?>
                    <div class="col-12 col-sm-auto mr-md-auto">
                        <div class="card">
                            <span class="d-block"><span class="h2 mb-0 "><?php echo $data['main']['total']; ?></span><span class="font-weight-bold mb-0">BTC</span></span>
                            <span class="mt-n2 text-grey-light d-block">Balance</span>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <picture>
            <source srcset="views/src/dist/images/hero-bg.webp" type="image/webp">
            <source srcset="views/src/dist/images/hero-bg.png" type="image/png">
            <img loading="lazy" class="hero-img lazy" src="views/src/dist/images/hero-bg.png" width="1920" height="1080" alt="Hero-BG">
        </picture>
    </section>
    <section>
        <div class="container mt-7">
            <div class="row">
                <?php 
                    if(!empty($data['results'])):
                        foreach($data['results'] as $result):
                            partial('results', $result);
                        endforeach;
                    endif;
                ?>
            </div>
        </div>
    </section>
@endsection