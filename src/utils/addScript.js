export default function addScript(src, id, callback) {

    if (!document.getElementById(id)) {
        const script = document.createElement("script");
        script.id = id;
        script.src = src;
        script.async = true;

        script.onload = () => {
            callback();
        };

        document.body.appendChild(script);
    } else {
        callback();
    }
}