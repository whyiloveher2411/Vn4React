import light from './light';
import dark from './dark';

const valueFace = { light: true, dark: true };

const view_mode = localStorage.getItem("view_mode");

if (!valueFace[view_mode]) view_mode = 'light';

let theme = light;

if (view_mode === 'dark') {
    theme = dark;
}

export default theme;
