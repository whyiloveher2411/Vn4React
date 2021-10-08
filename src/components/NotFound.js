import React from 'react';
import { __ } from 'utils/i18n';

function NotFound(props) {

    const { children, title = __('Nothing To Display.'), subTitle = __('Seems like no data have been created yet.') } = props;

    return (
        <h2 style={{ textAlign: 'center' }}>
            <img style={{ margin: '0 auto 16px', display: 'block', maxHeight: 350 }} src={props.img ?? "/img/notfound.svg"} alt="Logo" />
            <strong>
                {
                    children ?
                        children :
                        <>
                            {title} <br />
                            <span style={{ color: '#ababab', fontSize: '16px' }}>{subTitle}</span>
                            {children}
                        </>
                }
            </strong>
        </h2>
    )
}

export default NotFound
