import FieldForm from 'components/FieldForm';
import React from 'react';

function Overview(props) {

    if (props.post) {
        return (
            <FieldForm
                compoment='editor'
                config={{
                    title: 'Overview',
                    note: ' ',
                    maxLength: 70
                }}
                post={props.post}
                name='detailed_overview'
                onReview={(value) => props.onReview(value, 'detailed_overview')}
            />
        )
    }

    return <></>;
}

export default Overview
