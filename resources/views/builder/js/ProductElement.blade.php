<script>
    // cart items element
    class ProductElement extends SuperElement  {
        name() {
            return getI18n('block');
        }
        icon() {
            return 'fal fa-font';
        }

        getOptions() {
            return {
                preview: this.obj.attr('data-preview'),
                display: this.obj.attr('data-display'),
                id: this.obj.attr('data-id'),
                name: this.obj.attr('data-name'),
                content: this.getContent()
            };
        }

        getContent() {
            return this.getContainer().find('product').html();
        }

        setContent(html) {
            this.getContainer().find('product').html(html);
        }

        setOptions(options) {
            if (typeof(options.preview) != 'undefined') {
                this.obj.attr('data-preview', options.preview);
            }
            if (typeof(options.display) != 'undefined') {
                this.obj.attr('data-display', options.display);

                // reset frame
                this.resetFrameHtml();
                this.loadFrame();
            }
            if (typeof(options.id) != 'undefined') {
                this.obj.attr('data-id', options.id);
            }
            if (typeof(options.name) != 'undefined') {
                this.obj.attr('data-name', options.name);
            }

            this.render();
        }

        addLoadingEffect() {
            var _this = this;

            this.removeLoadingEffect();

            _this.obj.addClass('ace-loading');
            _this.obj.append(`<div class="ace-loader"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin: auto; background-image: none; display: block; shape-rendering: auto;" width="200px" height="200px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
                <circle cx="30" cy="50" fill="#774023" r="20">
                <animate attributeName="cx" repeatCount="indefinite" dur="1s" keyTimes="0;0.5;1" values="30;70;30" begin="-0.5s"/>
                </circle>
                <circle cx="70" cy="50" fill="#d88c51" r="20">
                <animate attributeName="cx" repeatCount="indefinite" dur="1s" keyTimes="0;0.5;1" values="30;70;30" begin="0s"/>
                </circle>
                <circle cx="30" cy="50" fill="#774023" r="20">
                <animate attributeName="cx" repeatCount="indefinite" dur="1s" keyTimes="0;0.5;1" values="30;70;30" begin="-0.5s"/>
                <animate attributeName="fill-opacity" values="0;0;1;1" calcMode="discrete" keyTimes="0;0.499;0.5;1" dur="1s" repeatCount="indefinite"/>
                </circle>
                <!-- [ldio] generated by https://loading.io/ --></svg></div>
            `);
        }

        removeLoadingEffect() {
            var _this = this;
            _this.obj.removeClass('ace-loading');
            _this.obj.find('.ace-loader').remove();
        }

        loadProduct() {
            var _this = this;
            var url = '{{ action('ProductController@widgetProduct') }}';

            _this.addLoadingEffect();

            $.ajax({
                method: "POST",
                url: url,
                data: $.extend( this.getOptions(), {
                    _token: CSRF_TOKEN
                } )
            })
            .done(function( data ) {
                _this.setContent(data);

                _this.removeLoadingEffect();

                currentEditor.select(_this);
                currentEditor.handleSelect();
            });         
        }

        render() {
            var _this = this;

            if (_this.getOptions().id == '') {
                _this.loadPlaceholder();
            } else if (_this.getOptions().preview == 'no') {
                _this.loadFrame();
            } else if (_this.getOptions().preview == 'yes') {
                _this.frameHtml = _this.getContent();
                _this.loadProduct();
            }
        }

        getContainer() {
            if (!this.obj.find('.container').length) {
                var div = $(`
                    <div>
                        <div style="padding-top:16px;padding-bottom:16px" class="container">
                            <div class="ace-controls" style="position:relative;display:none">
                                <span class="ace-button preview-but">Preview</span>
                                <span class="ace-button unpreview-but">Close preview</span>
                            </div>
                            <product class="row py-3">
                            </product>
                        </div>
                    <div>
                `)

                this.obj.html(div.html());
            }

            return this.obj.find('.container');
        }

        resetFrameHtml() {
            this.frameHtml = null;
            this.frameHtml = this.getDefaultFrameHtml();
        }

        getDefaultFrameHtml() {
            var _this = this;
            var options = this.getOptions();
            
            if (options.display == 'full') {
                return `
                    <div class="d-flex" style="width:100%">
                        <div class="">
                            <a href="*|PRODUCT_URL|*" class="product-link">
                                <img builder-element="ProductImgElement" class="mr-4" src="{{ url('images/product-image-placeholder.svg') }}" width="200px" />
                            </a>
                        </div>
                        
                        <div class="" style="width:100%">
                            <div builder-element="TextElement">
                                <h4 class="font-weight-normal">
                                    <a style="color:#333;" class="d-block product-link" href="*|PRODUCT_URL|*">
                                        <span class="product-name">*|PRODUCT_NAME|*</span>
                                    </a>
                                </h4>
                                <p class=" product-description">*|PRODUCT_DESCRIPTION|*</p>
                                <h4><strong class="product-price">*|PRODUCT_PRICE|*</strong></h4>
                            </div>
                            <div>
                                <a style="background-color: #9b5c8f;
    border-color: #9b5c8f;" builder-element builder-inline-edit href="*|PRODUCT_URL|*" class="mt-4 btn btn-primary text-white product-view-button product-link">
                                    {{ trans('messages.automation.buy_now') }}
                                </a>
                            </div>
                        </div>
                    </div>
                `;
            } else if (options.display == 'compact') {
                return `
                    <div class="d-flex" style="width:100%">
                        <div class="">
                            <a href="*|PRODUCT_URL|*" class="product-link">
                                <img builder-element="ProductImgElement" class="mr-4" src="{{ url('images/product-image-placeholder.svg') }}" width="120px" />
                            </a>
                        </div>
                        
                        <div class="" style="width:100%">
                            <div builder-element="TextElement">
                                <h5 class="font-weight-normal">
                                    <a style="color:#333;" class="d-block product-link" href="*|PRODUCT_URL|*">
                                        <span class="product-name">*|PRODUCT_NAME|*</span>
                                    </a>
                                </h5>
                                <p class=" product-description mb-1">*|PRODUCT_DESCRIPTION|*</p>
                                <strong class="product-price">*|PRODUCT_PRICE|*</strong>
                            </div>
                        </div>
                    </div>
                `;
            } else {
                return `
                    <div class="d-flex" style="width:100%">                        
                        <div class="" style="width:100%">
                            <div builder-element="TextElement">
                                <h4 class="font-weight-normal">
                                    <a style="color:#333;" class="d-block product-link" href="*|PRODUCT_URL|*">
                                        <span class="product-name">*|PRODUCT_NAME|*</span>
                                    </a>
                                </h4>
                                <p class=" product-description">*|PRODUCT_DESCRIPTION|*</p>
                                <h4><strong class="product-price">*|PRODUCT_PRICE|*</strong></h4>
                            </div>
                            <div>
                                <a style="background-color: #9b5c8f;
    border-color: #9b5c8f;" builder-element builder-inline-edit href="*|PRODUCT_URL|*" class="mt-4 btn btn-primary text-white product-view-button product-link">
                                    {{ trans('messages.automation.buy_now') }}
                                </a>
                            </div>
                        </div>
                    </div>
                `;
            }
        }

        getFrameHtml() {
            var _this = this;
            var options = this.getOptions();

            if (typeof(_this.frameHtml) == 'undefined' || _this.frameHtml == null) {
                _this.frameHtml = _this.getDefaultFrameHtml();
            }

            return _this.frameHtml;
        }

        loadFrame() {
            var _this = this;
            var options = this.getOptions();

            _this.setContent(_this.getFrameHtml());

            currentEditor.select(_this);
            currentEditor.handleSelect();
        }

        loadPlaceholder() {
            var _this = this;
            this.setContent(`
                <div class="product-placeholder text-center">
                    <img src="{{ url('images/product-image-placeholder.svg') }}" width="100%" />
                    <a style="" class="mt-4 btnx btnx-primary">
                        {{ trans('messages.automation.choose_a_product') }}
                    </a>
                </div>
            `);

            currentEditor.select(_this);
            currentEditor.handleSelect();
        }

        addEvents() {
            var element = this;
            var id = element.obj.attr('id');

            if (typeof(window.productWidgetEvents) == 'undefined') {
                window.productWidgetEvents = [];
            }

            if (typeof(window.productWidgetEvents[id]) == 'undefined') {
                window.productWidgetEvents[id] = true;

                // preview
                element.obj.find('.preview-but').on('click', function() {
                    element.setOptions({
                        preview: 'yes'
                    });
                });

                // unpreview
                element.obj.find('.unpreview-but').on('click', function() {
                    element.setOptions({
                        preview: 'no'
                    });
                });

                // before save
                currentEditor.addBeforeSaveEvent(function() {
                    element.setOptions({
                        preview: 'no'
                    });
                });
            }
        }

        getControls() {
            var element = this;

            element.addEvents();
            element.getFrameHtml();

            return [
                new ProductControl('{{ trans('messages.woo_item') }}', element.getOptions(), {
                    setOptions: function(options) {
                        element.setOptions(options);
                        element.select();
                    }  
                }),
                new FontFamilyControl(getI18n('font_family'), element.obj.css('font-family'), function(font_family) {
                    element.obj.css('font-family', font_family);
                    element.select();
                }),
                new BackgroundImageControl(getI18n('background_image'), {
                    image: element.obj.css('background-image'),
                    color: element.obj.css('background-color'),
                    repeat: element.obj.css('background-repeat'),
                    position: element.obj.css('background-position'),
                    size: element.obj.css('background-size'),
                }, {
                    setBackgroundImage: function (image) {
                        element.obj.css('background-image', image);
                    },
                    setBackgroundColor: function (color) {
                        element.obj.css('background-color', color);
                    },
                    setBackgroundRepeat: function (repeat) {
                        element.obj.css('background-repeat', repeat);
                    },
                    setBackgroundPosition: function (position) {
                        element.obj.css('background-position', position);
                    },
                    setBackgroundSize: function (size) {
                        element.obj.css('background-size', size);
                    },
                }),
                new BlockOptionControl(getI18n('block_options'), { padding: element.obj.css('padding'), top: element.obj.css('padding-top'), bottom: element.obj.css('padding-bottom'), right: element.obj.css('padding-right'), left: element.obj.css('padding-left') }, function(options) {
                    element.obj.css('padding', options.padding);
                    element.obj.css('padding-top', options.top);
                    element.obj.css('padding-bottom', options.bottom);
                    element.obj.css('padding-right', options.right);
                    element.obj.css('padding-left', options.left);
                    element.select();
                })
            ];
        }

        // preview() {
        //     var element = this;                

        //     element.obj.addClass('loading');

        //     if(element.obj.attr('product-id') == null || element.obj.attr('product-id') == '') {
        //         Swal.fire({
        //             title: '{{ trans('messages.woo_item.please_select_product') }}',
        //             text: '',
        //             type: 'warning',
        //             showCancelButton: true,
        //             confirmButtonColor: '#3085d6',
        //             cancelButtonColor: '#d33',
        //             confirmButtonText: '{{ trans('messages.ok') }}'
        //         }).then((result) => {
        //             element.obj.removeClass('loading');
        //         });
        //         return;
        //     }

        //     var url = '{{ action('ProductController@widgetProduct') }}';
        //     $.ajax({
        //         method: "GET",
        //         url: url,
        //         data: {
        //             product_id: element.obj.attr('product-id')
        //         }
        //     })
        //     .done(function( data ) {
        //         element.obj.attr('preview', 'yes');

        //         // replace
        //         var html = element.obj.find('.edit-container').html();
        //         html = html.replace(/\*\|PRODUCT_NAME\|\*/g, data.name);
        //         html = html.replace(/\*\|PRODUCT_DESCRIPTION\|\*/g, data.description);
        //         html = html.replace(/\*\|PRODUCT_PRICE\|\*/g, data.price);
        //         html = html.replace(/\*\|PRODUCT_QUANTITY\|\*/g, data.quantity);
        //         element.obj.find('.preview-container').html(html);
        //         if (data.image) {
        //             element.obj.find('.preview-container img').attr('src', data.image);
        //         }
        //         element.obj.find('.preview-container *').removeAttr('builder-element');

        //         if (editor.selected != null) {
        //             editor.selected.select();
        //         }

        //         element.obj.removeClass('loading');
        //     });             
        // }

        // unpreview() {
        //     var element = this;

        //     element.obj.addClass('loading');

        //     element.obj.attr('preview', 'no');

        //     // element.obj.find('.product-link img').attr('src', '{{ url('images/cart_item.svg') }}');
        //     // element.obj.find('.product-name').html('*|PRODUCT_NAME|*');
        //     // element.obj.find('.product-description').html('*|PRODUCT_DESCRIPTION|*');
        //     // element.obj.find('.product-link').attr('href', '*|PRODUCT_URL|*');
        //     // element.obj.find('.product-price').html('*|PRODUCT_PRICE|*');
        //     if (editor.selected != null) {
        //         editor.selected.select();
        //     }

        //     element.obj.removeClass('loading');
        // }

        // getControls() {
        //     var element = this;

        //     return [
        //         new ProductControl('{{ trans('messages.woo_item') }}', {
        //             id: element.obj.attr('product-id'),
        //             name: element.obj.attr('product-name'),
        //             preview: element.obj.attr('preview'),
        //             display: element.obj.attr('display'),
        //         }, {
        //             updateId: function(id) {
        //                 element.obj.attr('product-id', id);

        //                 if (!id) {
        //                     element.obj.removeAttr('product-id');
        //                 }

        //                 element.select();
        //             },
        //             updateName: function(name) {
        //                 element.obj.attr('product-name', name);

        //                 element.select();
        //             },
        //             preview: function(callback) {
        //                 element.preview();                            
        //                 if (callback) {
        //                     callback();
        //                 }
        //             },
        //             unpreview: function(callback) {
        //                 element.unpreview();
        //                 if (callback) {
        //                     callback();
        //                 }
        //             },
        //             display: function(display) {
        //                 element.obj.attr('display', display);

        //                 if (display == 'full') {
        //                     element.obj.find('img').show();
        //                     element.obj.find('img').css('width', '200px');
        //                     element.obj.find('.product-view-button').show();
        //                 }

        //                 if (display == 'compact') {
        //                     element.obj.find('img').show();
        //                     element.obj.find('img').css('width', '100px');
        //                     element.obj.find('.product-view-button').hide();
        //                 }

        //                 if (display == 'no_image') {
        //                     element.obj.find('img').hide();
        //                     element.obj.find('.product-view-button').hide();
        //                 }
        //             }
        //         }),
        //         new FontFamilyControl(getI18n('font_family'), element.obj.css('font-family'), function(font_family) {
        //             element.obj.css('font-family', font_family);
        //             element.select();
        //         }),
        //         new BackgroundImageControl(getI18n('background_image'), {
        //             image: element.obj.css('background-image'),
        //             color: element.obj.css('background-color'),
        //             repeat: element.obj.css('background-repeat'),
        //             position: element.obj.css('background-position'),
        //             size: element.obj.css('background-size'),
        //         }, {
        //             setBackgroundImage: function (image) {
        //                 element.obj.css('background-image', image);
        //             },
        //             setBackgroundColor: function (color) {
        //                 element.obj.css('background-color', color);
        //             },
        //             setBackgroundRepeat: function (repeat) {
        //                 element.obj.css('background-repeat', repeat);
        //             },
        //             setBackgroundPosition: function (position) {
        //                 element.obj.css('background-position', position);
        //             },
        //             setBackgroundSize: function (size) {
        //                 element.obj.css('background-size', size);
        //             },
        //         }),
        //         new BlockOptionControl(getI18n('block_options'), { padding: element.obj.css('padding'), top: element.obj.css('padding-top'), bottom: element.obj.css('padding-bottom'), right: element.obj.css('padding-right'), left: element.obj.css('padding-left') }, function(options) {
        //             element.obj.css('padding', options.padding);
        //             element.obj.css('padding-top', options.top);
        //             element.obj.css('padding-bottom', options.bottom);
        //             element.obj.css('padding-right', options.right);
        //             element.obj.css('padding-left', options.left);
        //             element.select();
        //         })
        //     ];
        // }
    }
</script>