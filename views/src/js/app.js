import './_animation' 
import LazyLoad from "vanilla-lazyload"

export const lazyLoad = new LazyLoad({
	elements_selector: '.lazy',
	use_native: true
})

var copyTextareaBtn = document.querySelector('.btn-copy')

copyTextareaBtn.addEventListener('click', function(event) {
	var copyTextarea = document.querySelector('.form-copy')
	copyTextarea.focus()
	copyTextarea.select()

	try {
		var successful = document.execCommand('copy')
		var msg = successful ? 'successful' : 'unsuccessful'
	} catch (err) {
		console.log('Oops, unable to copy')
	}
})