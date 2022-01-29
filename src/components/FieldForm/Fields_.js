import React from 'react'

const FieldView = ({ ...args }) => {
    let resolved = require(`./${args.compoment}/View`).default;
    return React.createElement(resolved, { ...args });
}

function Fields( props ) {
    return (
        <FieldView {...props}></FieldView>
    )
}

export default Fields



