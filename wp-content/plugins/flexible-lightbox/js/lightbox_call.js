jQuery(function() {		   
	jQuery('a.lightbox').lightBox({   
							 imageLoading:path+'lightbox-ico-loading.gif',		
			                 imageBtnPrev:path+'lightbox-btn-prev.gif',			
			                 imageBtnNext:path+'lightbox-btn-next.gif',
			                 imageBtnClose:path+'lightbox-btn-close.gif',
			                 imageBlank:path+'lightbox-blank.gif'
							 });	
	
	jQuery('.gallery a').lightBox({   
							 imageLoading:path+'lightbox-ico-loading.gif',		
			                 imageBtnPrev:path+'lightbox-btn-prev.gif',			
			                 imageBtnNext:path+'lightbox-btn-next.gif',
			                 imageBtnClose:path+'lightbox-btn-close.gif',
			                 imageBlank:path+'lightbox-blank.gif'
							 })
});
