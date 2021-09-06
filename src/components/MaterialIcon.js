import React from 'react'
import SvgIcon from '@material-ui/core/SvgIcon';

function MaterialIcon({ icon, className, ...rest }) {

    if (!icon) {
        return <></>;
    }

    if (typeof icon === 'object' && icon.custom) {
        return <SvgIcon className={className} {...rest}> <svg dangerouslySetInnerHTML={{ __html: icon.custom }
        } /></SvgIcon>
    }

    try {
        let resolved = require(`@material-ui/icons/${icon}`).default;
        return React.createElement(resolved, { ...rest, className: className });
    } catch (error) {
        return <></>;
    }

}

export default MaterialIcon
