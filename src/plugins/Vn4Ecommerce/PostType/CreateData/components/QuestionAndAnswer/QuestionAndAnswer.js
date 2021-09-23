import FieldForm from 'components/FieldForm';
import React from 'react';
import { Skeleton } from '@material-ui/lab'

function QuestionAndAnswer(props) {

    if (props.post) {
        return (
            <FieldForm
                compoment='repeater'
                config={{
                    title: 'Question And Answer',
                    sub_fields: {
                        question: { title: 'Question' },
                        answer: { title: 'Answer', view: 'textarea' },
                    }
                }}
                post={props.post}
                name='question_and_answer'
                onReview={(value) => props.onReview(value, 'question_and_answer')}
            />
        )
    }

    return [1, 2, 3, 4, 5, 6].map((item) => (
        <Skeleton key={item} variant="rect" width={'100%'} style={{ marginBottom: 16 }} height={52} />
    ));
}

export default QuestionAndAnswer

