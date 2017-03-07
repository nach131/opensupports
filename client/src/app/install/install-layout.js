import React from 'react';
import classNames from 'classnames';

import i18n from 'lib-app/i18n';

import Widget from 'core-components/widget';
import Icon from 'core-components/icon';

const steps = [
    'LANGUAGE',
    'SERVER_REQUIREMENTS',
    'SETTINGS_SETUP',
    'ADMIN_SETUP',
    'INSTALL',
    'COMPLETED'
];

class InstallLayout extends React.Component {

    render() {
        return (
            <Widget className="install-layout">
                <div className="install-layout__header">
                    <div className="install-layout__header-logo">
                        <img width="100%" src="../../images/logo.png" alt="OpenSupports Installation"/>
                    </div>
                    <div className="install-layout__header-text">
                        <div className="install-layout__header-title">
                            {i18n('INSTALL_HEADER_TITLE')}
                        </div>
                        <div className="install-layout__header-description">
                            {i18n('INSTALL_HEADER_DESCRIPTION')}
                        </div>
                    </div>
                </div>
                <span className="separator"/>
                <div className="install-layout__body row">
                    <div className="col-md-3">
                        <ul className="install-layout__steps">
                            {steps.map(this.renderStep.bind(this))}
                        </ul>
                    </div>
                    <div className="install-layout__content col-md-9">
                        {this.props.children}
                    </div>
                </div>
            </Widget>
        );
    }

    renderStep(key, index) {
        let classes = {
            'install-layout__step': true,
            'install-layout__step_current': index === this.getCurrentStep(),
            'install-layout__step_previous': index < this.getCurrentStep()
        };
        let icon = 'circle-thin';

        if(index === this.getCurrentStep()) {
            icon = 'arrow-circle-right';
        } else if(index < this.getCurrentStep()) {
            icon = 'check-circle';
        }

        return (
            <li className={classNames(classes)}>
                <Icon name={icon} size="sm" className="install-layout__step-icon"/>
                <span className="install-layout__step-text">
                    {index+1}. {i18n(key)}
                </span>
            </li>
        )
    }

    getCurrentStep() {
        return 2;
    }
}

export default InstallLayout;