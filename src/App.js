import React from 'react';
import ReactDOM from 'react-dom';

/* Main Compnent */
import '@Admin/App.scss';
import Settings from '@Admin/Settings'

ReactDOM.render(
	<React.StrictMode>
		<Settings />
	</React.StrictMode>,
	document.getElementById( 'tws-settings-app' )
);
