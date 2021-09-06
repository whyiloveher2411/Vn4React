import React from 'react';

function NotFound(props) {

    const { children } = props;
    
    return (
        <h2 style={{ textAlign: 'center' }}>
            <img style={{ margin: '0 auto 16px', display: 'block', maxHeight: 350 }} src={props.img ?? "/img/notfound.svg"} alt="Logo" />
            <strong>
                {children}
            </strong>
        </h2>
    )
}

export default NotFound
