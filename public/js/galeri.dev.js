/**
 * jQuery load
 */
$(function() {
	/**
	 * konfigurasi wookmark
	 *
	 * @var array
	 */
	var opsi = {
		align: "center",
		autoResize: true,
		comparator: null,
		container: $("body"),
		direction: "left",
		ignoreInactiveItems: true,
		itemWidth: 300,
		fillEmptySpace: false,
		flexibleWidth: true,
		offset: 2,
		outerOffset: 20,
		resizeDelay: 50
	};

	// inisialisasi
	init();

	/**
	 * inisialisasi plugins & elemen
	 * 
	 * @return void
	 */
	function init() {
		// terapkan wookmark
		$("#galeri li").wookmark(opsi);

		// konfigurasi colorbox
		$("#galeri li a").colorbox({
			rel: "lightbox",
			speed: 500,
			opacity: 0.9,
			current: "Gambar ke {current} dari {total}",
			previous: "Sebelumnya",
			next: "Selanjutnya",
			close: "Tutup",
			xhrError: "Konten gagal dimuat",
			imgError: "Gambar gagal dimuat"
		});

		// paginasi
		paginasi();

		$(".pager").css("display", "none");
	}	

	/**
	 * paging
	 *
	 * @var null
	 */
	var paging;

	/**
	 * paginasi
	 * 
	 * @return void
	 */
	function paginasi() {
		paging = setInterval(function() {
			// ambil nilai atribut data-target
			var data = $(".pager a").data("target");

			if (data != null) {
				// muat gambar lainnya
				galeri(data);

				// ambil nomor dari url sekarang
				var no = data.substring(data.lastIndexOf("=") + 1);

				// link paginasi berikutnya
				var tambah = (parseInt(no) + 1);

				// rubah nomor url terakhir 
				var link = data.replace(no, tambah);

				// nilai maksimal paginasi
				var max = $("#max").val();

				stop();

				// jika sudah di akhir paginasi
				if (tambah > max) {
					// hilangkan paginasi
					$(".pager a").data("target", null);

					$(".modal").modal("show");

				// belum diakhir paginasi
				} else {
					// masukkan ke atribut data-target
					$(".pager a").data("target", link);
				};
			};
		}, 1000);
	};

	/**
	 * stop interval
	 * 
	 * @return void
	 */
	function stop() {
		clearInterval(paging);
	}

	/**
	 * muat ulang gambar lainnya
	 * 
	 * @param  string data
	 * @return void
	 */
	function galeri(data) {
		// request get
		$.get(data, function(html) {
			// tambah gambar
			$("#galeri").append(html);

			// inisialisasi
			init();
		});
	}
})