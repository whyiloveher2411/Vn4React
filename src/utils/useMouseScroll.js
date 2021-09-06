let pos = { top: 0, left: 0, x: 0, y: 0 };

export function onMouseMove(e, useRefDir) {

    e.stopPropagation();
    e.preventDefault();


    if (useRefDir.style.userSelect) {
        // How far the mouse has been moved

        const dx = e.clientX - pos.x;
        // const dy = e.clientY - pos.y;

        if (Math.abs(dx) > 5) {
            window._isOnMouseSrollMove = true;
        }

        // Scroll the element
        // useRefDir.scrollTop = pos.top - dy;
        useRefDir.scrollLeft = pos.left - dx;
    }
}

export function onMouseUp(e, useRefDir) {
    window._isOnMouseSrollUp = true;

    e.stopPropagation();
    e.preventDefault();
    useRefDir.style.cursor = 'grab';
    useRefDir.style.removeProperty('user-select');
}

export function onMouseDown(e, useRefDir) {

    window._isOnMouseSrollDown = true;

    e.stopPropagation();
    e.preventDefault();
    pos = {
        // The current scroll 
        left: useRefDir.scrollLeft,
        top: useRefDir.scrollTop,
        // Get the current mouse position
        x: e.clientX,
        // y: e.clientY,
    };

    useRefDir.style.cursor = 'grabbing';
    useRefDir.style.userSelect = 'none';

    document.body.onmouseup = () => {
        useRefDir.style.removeProperty('user-select');
        setTimeout(() => {
            delete window._isOnMouseSrollUp;
            delete window._isOnMouseSrollDown;
            delete window._isOnMouseSrollMove;
        }, 100);
    };
}

export function isMouseScroll() {
    if (window._isOnMouseSrollUp && window._isOnMouseSrollDown && window._isOnMouseSrollMove) {
        return true;
    }
    return false;
}