<?php

namespace Opifer\CmsBundle\ValueProvider;

use Opifer\EavBundle\ValueProvider\AbstractValueProvider;
use Opifer\EavBundle\ValueProvider\ValueProviderInterface;
use Symfony\Component\Form\FormBuilderInterface;

class FormValueProvider extends AbstractValueProvider implements ValueProviderInterface
{
    /** @var string */
    protected $formClass;

    /**
     * @param string $formClass
     */
    public function __construct($formClass)
    {
        $this->formClass = $formClass;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('form', 'entity', [
            'empty_value' => '-- None --',
            'expanded' => false,
            'multiple' => false,
            'class' => $this->formClass,
            'property' => 'name',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getEntity()
    {
        return 'Opifer\CmsBundle\Entity\FormValue';
    }

    /**
     * {@inheritdoc}
     */
    public function getLabel()
    {
        return 'Form';
    }
}
