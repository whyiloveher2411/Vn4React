import React from 'react';
import MultiChoose2 from './MultiChoose2';
import OnlyOneChoose2 from './OnlyOneChoose2';

export default React.memo(function ImageForm(props) {

    const { config } = props;

    if( config.multiple ){
        return <MultiChoose2 {...props} />
    }

    return <OnlyOneChoose2 {...props} />
}, (props1, props2) => {
    return props1.post[props1.name] === props2.post[props2.name];
})