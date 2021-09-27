import { validURL } from "./herlperUrl";

export function getImageUrl(img) {

    if (typeof img === 'string') {
        img = JSON.parse(img);
    }

    if (typeof img === 'object') {
        return validURL(img.link) ? img.link : process.env.REACT_APP_BASE_URL + img.link;
    }

    return false;
}