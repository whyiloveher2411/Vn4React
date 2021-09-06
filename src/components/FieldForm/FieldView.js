import React from 'react'
import Hook from '../Hook';
import FieldForm from './FieldForm';

function FieldView(props) {

    if (props.config.inlineEdit) {
        return <div onClick={e => e.stopPropagation()}>
            <FieldForm {...props} onReview={(value, key) => props.actionLiveEdit(value, key ?? props.name, props.post)} inlineEdit />
        </div>
    }

    if (props.config?.customViewList) {
        return <Hook hook={props.config.customViewList} fieldtype="list" {...props} />
    }

    let resolved = require(`./${props.compoment}/View`).default;
    return React.createElement(resolved, { ...props, fieldtype: "list" });
}

export default FieldView



