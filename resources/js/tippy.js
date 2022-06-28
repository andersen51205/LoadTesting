import tippy from 'tippy.js';
import 'tippy.js/dist/tippy.css'; // optional for styling
import 'tippy.js/animations/scale.css';

tippy.setDefaultProps({
	allowHTML: false,
	animation: 'scale',
	duration: [150, null]
});

/**
 * 使用方法：
 * 傳入需要建立tippy Label的區塊
 */
 window.setTippyLabel = (section) => {
	const elements = section.querySelectorAll('.tooltip-label');
	clearTippyLabel(section);
	tippy(elements);
}

/**
 * 使用方法：
 * 傳入需要清除tippy Label的區塊
 */
window.clearTippyLabel = (section) => {
	const elements = section.querySelectorAll('.tooltip-label');
	for(let i=0; i<elements.length; i++) {
		if (elements[i]._tippy) {
			elements[i]._tippy.destroy();
		}
	}
}
