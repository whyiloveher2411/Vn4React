import React from 'react';
import MultiChoose2 from './MultiChoose2';
import OnlyOneChoose2 from './OnlyOneChoose2';

export default function ImageForm(props) {

    const { config } = props;

    if( config.multiple ){
        return <MultiChoose2 {...props} />
    }

    return <OnlyOneChoose2 {...props} />
}