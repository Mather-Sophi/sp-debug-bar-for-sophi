import '../../css/shared/shared-style.scss';
import ReactJson from 'react-json-view';
import ReactDOM from 'react-dom';

document.addEventListener('DOMContentLoaded', () => {
	const jsonContainers = document.getElementsByClassName('sophi-json-view');

	for (let i = 0; i < jsonContainers.length; i++) {
		const jsonContainer = jsonContainers.item(i);
		const jsonData = jsonContainer.textContent;

		try {
			const json = JSON.parse(jsonData);

			ReactDOM.render(
				<ReactJson
					src={json}
					displayDataTypes={false}
					enableClipboard={false}
					quotesOnKeys={false}
					collapsed
				/>,
				jsonContainer,
			);
		} catch (e) {
			/* eslint no-console: ["error", { allow: ["error"] }] */
			console.error(e.message);
		}
	}
});
