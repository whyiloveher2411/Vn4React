import FieldForm from 'components/FieldForm';
import React from 'react';
import { __p } from 'utils/i18n';

function Overview(props) {

    if (props.post) {
        return (
            <FieldForm
                compoment='editor'
                config={{
                    title: __p('Overview', props.PLUGIN_NAME),
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
