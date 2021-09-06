import React from 'react'
import Hook from '../Hook';

function FieldForm(props) {
    if (props.config?.customViewForm) {
        return <Hook hook={props.config.customViewForm} fieldtype={"form"} {...props} />
    }

    let resolved = require(`./${props.compoment}/Form`).default;
    return React.createElement(resolved, { ...props, fieldtype: "form" });
}

export default FieldForm
