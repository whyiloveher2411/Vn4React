import Summary from './Summary';

export default function (props) {


    if (props.action === 'EDIT') {
        return {
            summary: {
                title: 'Summary',
                component: (props) => <Summary {...props} />,
                priority: 0,
            }
        };
    }

    return {};

}