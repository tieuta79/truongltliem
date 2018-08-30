<style scoped>
    label[for="product-select-option-0"] { display: none; }
    #product-select-option-0 { display: none; }
    #product-select-option-0 + .custom-style-select-box { display: none !important; }
</style>
<div class="left-form-action col-sm-12">
    <div class="swatch color clearfix" data-option-index="0">
        <div class="header">Loại vàng</div>
        <div data-value="white" class="swatch-element color white available">
            <div class="tooltip">Bạc</div>
            <input id="swatch-0-white" name="option-0" value="white" type="radio" />
            <label for="swatch-0-white" style="background-color: white; background-image: url(images/white.png)" />
            <img class="crossed-out" src="images/soldout.png" alt="" />
            </label>
        </div>
        <div data-value="blue" class="swatch-element color blue available">
            <div class="tooltip">Vàng</div>
            <input id="swatch-0-yellow" name="option-0" value="yellow" type="radio">
            <label for="swatch-0-blue" style="background-color: yellow; background-image: url(images/yellow.png)" />
            <img class="crossed-out" src="images/soldout.png" alt="" />
            </label>
        </div>																	
    </div>
    <div class="swatch clearfix" data-option-index="1">
        <div class="header">Kích thước</div>
        <div class="">
            <select data-option="option1" class="" name="size">
                <option value="4">4</option>
                <option value="4 1/2">4 1/2</option>
                <option value="5">5</option>
                <option value="5 1/2">5 1/2</option>
                <option value="6">6</option>
                <option value="6 1/2">6 1/2</option>
            </select>
        </div>
    </div>
    <div class="quantity-wrapper">                                                                                
        <label class="quantity-wrapper-title">Quantity</label>
        <div class="wrapper">
            <input id="quantity" name="quantity" value="1" maxlength="5" size="5" class="item-quantity" type="number" />
        </div>
    </div>                                                                            
</div>