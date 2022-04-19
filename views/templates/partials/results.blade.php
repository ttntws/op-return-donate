<div class="col-md-7 mx-auto mb-6 selector">
    <div class="card bg-primary text-white z-index-1 position-relative card-arrow">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-12 col-md-auto font-size-lg pl-5 text-center text-md-left">
                    <?php echo $opReturn; ?>
                </div>
                <div class="col-auto ml-auto mr-auto mr-md-0 mt-3 mt-md-0">
                    <div class="bg-white rounded text-grey font-weight-bold px-2 py-1 p-md-3 donation">
                        <?php echo formatBTC(convertToBTCFromSatoshi($balance)); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php if(!empty($isFirst) && $isFirst !== null && $isFirst === true): ?>
    <div class="row align-items-center mt-6 mb-3">
        <div class="col-3 ml-auto d-none d-sm-block align-items-center">
            <hr>
        </div>
        <div class="col-auto d-flex align-items-center ml-auto ml-sm-0 mr-auto mr-sm-0">
            <img class="img-fluid mb-0 mr-3 mt-n1" src="views/src/dist/images/star.svg" width="27" height="25">
            <strong>Highest donation</strong>
        </div>
        <div class="col-3 mr-auto d-none d-sm-block align-items-center">
            <hr>
        </div>
    </div>
    <?php endif; ?>
</div>