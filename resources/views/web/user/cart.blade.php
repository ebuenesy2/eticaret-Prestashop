<!DOCTYPE html>
<html lang="@lang('admin.lang')" >
<head>
    
	<title> @lang('admin.myCart') | {{ $DB_HomeSettings->title }} </title>
    
    <!------- Head --->
    @include('web.include.head')
    
</head>

<body>
    <div class="page-wrapper">
                                 
        <!------- Header --->
        @include('web.include.header')

        <main class="main" id="cart_info" data_products_currency="0" data_time="{{time()}}"  >
        	<div class="page-header text-center" style="background-image: url('assets/images/page-header-bg.jpg')">
        		<div class="container">
        			<h1 class="page-title">@lang('admin.myCart')</h1>
        		</div><!-- End .container -->
        	</div><!-- End .page-header -->
            <nav aria-label="breadcrumb" class="breadcrumb-nav">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/@lang('admin.lang')">@lang('admin.home')</a></li>
                        <li class="breadcrumb-item active" aria-current="page">@lang('admin.myCart')</li>
                    </ol>
                </div><!-- End .container -->
            </nav><!-- End .breadcrumb-nav -->
            <div class="page-content">
            	<div class="cart">
	                <div class="container">

					@if(session('status') == "success")
						<div class="alert alert-success " role="alert" style="margin-bottom: 16px;"> {{session('msg')}}  </div>
					@elseif(session('status') == "error")
						<div class="alert alert-danger " role="alert" style="margin-bottom: 16px;"> {{session('msg')}}  </div>
					@endif	
   

	                	<div class="row">
	                		<div class="col-lg-9">
	                			<table class="table table-cart table-mobile" >
									<thead>
										<tr>
											<th>@lang('admin.product')</th>
											<th>@lang('admin.salePrice')</th>
											<th>@lang('admin.quantity')</th>
											<th>@lang('admin.total')</th>
											<th></th>
										</tr>
									</thead>

									<tbody>

										
										
									</tbody>
								</table><!-- End .table table-wishlist -->

								<!-- İndirim -->
	                			<div class="cart-bottom" style="display: flex;justify-content: space-between;" >
			            			
								    <!-- İskonta Oranı -->
								    <div style="display:flex;">
								      <label for="discountedPercent" style="display: flex;align-items: center;" >İskonta Oranı % : </label>
									  <input type="text" class="form-control" id="discountedPercent" value="0" style="width: 25%;margin-left: 15px;" >
			            			</div>
									<!-- İskonta Oranı - Son -->

									<!-- İskonta Fiyatı -->
			            			<div style="display:flex;">
								      <label for="discountedPrice" style="display: flex;align-items: center;" >İskonta Fiyatı</label>
									  <input type="text" class="form-control" id="discountedPrice" value="0" style="width: 50%; margin-left: 15px;">
			            			</div>
									<!-- İskonta Fiyatı - Son -->

		            			</div>
								<!-- İndirim Son -->

								<!-- Kart Buttonlar -->
								<div class="cart-bottom">
			            			<div class="cart-discount">
									 <a id="CartDeleteAll" class="btn btn-outline-dark-2 btn-block mb-3" style="background-color: red;color: white; cursor:pointer; "><span>Sepet Boşalt</span></a>
			            			</div><!-- End  coupon -->

			            			<a id="CartUpdate" style="cursor:pointer;" class="btn btn-outline-dark-2"><span>Sepet Güncelle</span><i class="fa fa-refresh"></i></a>
		            			</div>
								<!-- Kart Buttonlar Son -->

	                		</div><!-- End .col-lg-9 -->
	                		<aside class="col-lg-3">
	                			<div class="summary summary-cart">
	                				<h3 class="summary-title">Sepet Toplam</h3><!-- End .summary-title -->

	                				<table class="table table-summary">
	                					<tbody>

											<!-- Sepet Fiyatı -->
	                						<tr class="summary-subtotal">
	                							<td>Sepet Fiyatı:</td>
	                							<td id="productTotalPrice" productsAllTotalPrice="{{$productsAllTotalPrice}}">{{$productsAllTotalPrice}} {{$productsCurrency}} </td>
	                						</tr>
											<!-- Sepet Fiyatı Son -->

											<!-- İnd -->
											<tr class="summary-subtotal">
	                							<td>İndirim Fiyat:</td>
	                							<td id="productDiscountPrice"> 0 {{$productsCurrency}} </td>
	                						</tr>
											<!-- Kupon Kodu Son -->

											<!-- Genel Fiyatı -->
	                						<tr class="summary-total">
	                							<td>Toplam Sepet Fiyatı:</td>
	                							<td id="productResultPrice" >{{$productsAllTotalPrice}} {{$productsCurrency}}</td>
	                						</tr>
											<!-- Genel Fiyatı Son -->

	                					</tbody>
	                				</table><!-- End .table table-summary -->
									<hr/>

									<!-- Sipariş Adı -->
			            			<div style="display:flex;flex-direction: column;" >
								      <label for="orderName">Sipariş Adı</label>
									  <input type="text" class="form-control" id="orderName" value="Alınacak Urun Listesi">
			            			</div>
									<!-- Sipariş Adı - Son -->

	                				<a id="orderCreate" style="cursor:pointer;" class="btn btn-outline-primary-2 btn-order btn-block">Sipariş Oluştur</a>


	                			</div><!-- End .summary -->

								<div class="cart-discount">
									 <a href="/@lang('admin.lang')/product/list" class="btn btn-outline-dark-2 btn-block mb-3"><span>Alışverişe Devam Et</span></a>
			            		</div><!-- End  coupon -->

	                		</aside><!-- End .col-lg-3 -->
	                	</div><!-- End .row -->


	                </div><!-- End .container -->
                </div><!-- End .cart -->
            </div><!-- End .page-content -->
        </main><!-- End .main -->

        <footer class="footer">
        	<div class="footer-middle">
	                         
                <!------- Footer - Container --->
                @include('web.include.footer-container')

	        </div><!-- End .footer-middle -->

	        <div class="footer-bottom">
	        	<div class="container">
	        		                                    
                    <!------- Footer - Copyright --->
                    @include('web.include.footer-copyright')
                    
	        	</div><!-- End .container -->
	        </div><!-- End .footer-bottom -->
        </footer><!-- End .footer -->
    </div><!-- End .page-wrapper -->
             
    <!------- Footer - Bottom --->
    @include('web.include.footer-bottom')

</body>

<!------  Iframe -->
<iframe id="iFramePdf" src="" style="display:none;"></iframe>

<script>
	document.addEventListener("DOMContentLoaded", function() {
		const cartTableBody = document.querySelector("table.table-cart tbody");
		const productTotalPrice = document.getElementById("productTotalPrice");
		const productResultPrice = document.getElementById("productResultPrice");

		// LocalStorage'dan ürün ID'lerini al
		let cartItems = JSON.parse(localStorage.getItem("cart")) || [];
		console.log("cartItems:",cartItems);
		
		let cartItemsData = []; //! Urun Listesi

		updateCartDisplay(); //! Fonksiyon Çalıştırma - Tablo Verileri Listeliyor

		//! Urunleri Listeleme
		function updateCartDisplay() {
			cartTableBody.innerHTML = ""; // Önce listeyi temizle
			let totalCartPrice = 0;
			
			// Verileri Laravel'e POST isteği ile gönder
			fetch('/user/cart/local', {
				method: 'POST',
				headers: {
					'Content-Type': 'application/json', // JSON formatında veri gönderiyoruz
					'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // CSRF token
				},
				body: JSON.stringify({ cart: cartItems }) // LocalStorage verisini gönderiyoruz
			})
			.then(response => response.json())
			.then(data => {
				console.log("Server response:", data); // Gelen cevabı kontrol et

				cartItemsData = data.data; //! Urun Listesi

				//! Urunleri Listeliyor
				data.data.forEach((item, index) => {
					
					let row = document.createElement("tr");

					row.innerHTML = `
						<td class="product-col">
							<div class="product">
								<figure class="product-media">
									<a href="/product/view/${item.id}">
										<img src="${item.image}" alt="${item.name}">
									</a>
								</figure>
								<h3 class="product-title">
									<a href="/product/view/${item.id}">${item.name}</a>
								</h3>
							</div>
						</td>
						<td class="price-col">${item.price} TL </td>
						<td class="quantity-col">
							<div class="cart-product-quantity"> ${item.quantity} </div>
						</td>
						<td class="total-col">${(item.price * item.quantity).toFixed(2)} TL </td>
						<td class="remove-col">
							<button class="btn-remove" data-index="${index}">
								<i class="fa fa-close" style="color: red;"></i>
							</button>
						</td>
					`;

					totalCartPrice += item.price * item.quantity;
					cartTableBody.appendChild(row);	
					
				});
				//! Urunleri Listeliyor Son

				productTotalPrice.innerText = `${totalCartPrice.toFixed(2)} TL`;
				productResultPrice.innerText = `${totalCartPrice.toFixed(2)} TL`;
				
			})
			.catch(error => {
				console.error("Error sending data:", error); // Hataları kontrol et
			});
			
		}//! Urunleri Listeleme 
		
		// Ürün Silme
		cartTableBody.addEventListener("click", function(e) {
			if (e.target.closest(".btn-remove")) {
				let index = e.target.closest(".btn-remove").getAttribute("data-index");
				cartItems.splice(index, 1);
				localStorage.setItem("cart", JSON.stringify(cartItems));
				updateCartDisplay();
			}
		});

		//! Sepet - Güncelleme
		document.querySelector('#CartUpdate').addEventListener('click', e => { updateCartDisplay(); }); 

		//! Sepet - Güncelleme - Sil
		document.querySelector('#CartDeleteAll').addEventListener('click', e => { 

			var cartItems = [];
			localStorage.setItem("cart", JSON.stringify(cartItems));

			cartTableBody.innerHTML=''; //! Tabloyu sıfırladı

		}); //! Sepet - Güncelleme - Sil Son


		//! Sepet - Sipariş Oluşturma
		document.querySelector('#orderCreate').addEventListener('click', e => { 

			//console.log("cartItemsData:",cartItemsData);

			let orderName = $('#orderName').val(); //! Sipariş Adı
			let totalValue = 0; // Toplam Değer Hesaplama

			// Tabloyu Oluştur
			let divToPrintHTML = "<table border='1' style='width: 100%; border-collapse: collapse;'>";
			divToPrintHTML += `
				<h1>Sipariş Adı: ${orderName}</h1> <!-- Sipariş Adı -->
				<thead>
					<tr>
						<th>Ürün ID</th>
						<th>Ürün Adı</th>
						<th>Fiyat</th>
						<th>Adet</th>
						<th>Resim</th>
						<th>Toplam</th>
					</tr>
				</thead>
				<tbody>
			`;

			cartItemsData.forEach(item => {
				const totalPrice = (item.price * item.quantity).toFixed(2); // Toplam fiyat
				totalValue += parseFloat(totalPrice); // Genel toplamı artır
				divToPrintHTML += `
					<tr>
						<td>${item.id}</td>
						<td>${item.name}</td>
						<td>${item.price} TL</td>
						<td>${item.quantity}</td>
						<td><img src="${item.image}" alt="${item.name}" width="50"></td>
						<td>${totalPrice} TL</td>
					</tr>
				`;
			});

			divToPrintHTML += `
					</tbody>
				</table>
				<h3 style="text-align: right;">Toplam Değer: ${totalValue.toFixed(2)} TL</h3> <!-- Toplam Değer -->
			`;

			
			//! Export
			var new_window = document.getElementById("iFramePdf").contentWindow; //! İframe
			var new_windowDocument = new_window.document; //! Veri

			$("body",new_windowDocument).html(""); //! Sıfırlama
			$("body",new_windowDocument).append(divToPrintHTML); //! Ekran Ekleme

			var new_window = new_window.print(); //! Ekran Çıktısı
			//! Export Son
		

		}); //! Sepet - Sipariş Oluşturma  Son
		
		

	});
</script>


</html>