import React from 'react';
import MultiChoose2 from './MultiChoose2';
import OnlyOneChoose2 from './OnlyOneChoose2';

export default function ImageForm(props) {

    const { config } = props;

    const [times, setTimes] = React.useState(0);

    const onReview = (value) => {
        if (times > 0) {
            props.onReview(value);
        }
        setTimes(prev => prev + 1);
    }

    if (config.multiple) {
        if (times % 2 === 0) {
            return <div><MultiChoose2 {...props} onReview={onReview} times={times} /></div>
        } else {
            return <MultiChoose2 {...props} onReview={onReview} times={times} />
        }
    }

    return <OnlyOneChoose2 {...props} />
}