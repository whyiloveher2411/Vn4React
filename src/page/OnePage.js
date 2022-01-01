import React from 'react';
import { useParams } from 'react-router-dom';
import { toCamelCase } from 'utils/helper';
import Home from './Home';

function OnePage() {

    let { page, tab, subtab1, subtab2 } = useParams();

    if (page) {
        try {
            let pageCompoment = toCamelCase(page);

            try {
                if (subtab2) {
                    let resolved = require('./OnePage/' + pageCompoment + '/' + toCamelCase(tab) + '/' + toCamelCase(subtab1) + '/' + toCamelCase(subtab2)).default;
                    return React.createElement(resolved, { page: page });
                }
            } catch (error) {

            }

            try {
                if (subtab1) {
                    let resolved = require('./OnePage/' + pageCompoment + '/' + toCamelCase(tab) + '/' + toCamelCase(subtab1)).default;
                    return React.createElement(resolved, { page: page });
                }
            } catch (error) {

            }

            try {
                if (tab) {
                    let resolved = require('./OnePage/' + pageCompoment + '/' + toCamelCase(tab)).default;
                    return React.createElement(resolved, { page: page });
                }
            } catch (error) {

            }

            let resolved = require('./OnePage/' + pageCompoment).default;
            return React.createElement(resolved, { page: page });
            // }
        } catch (error) {
          
        }
    }

    return <Home page={page} />
}

export default OnePage
