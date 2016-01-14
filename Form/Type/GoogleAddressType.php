<?php

namespace Opifer\CmsBundle\Form\Type;

use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

/**
 * Google address form type.
 *
 * @author  Rick van Laarhoven <r.vanlaarhoven@opifer.nl>
 */
class GoogleAddressType extends AbstractType
{
    /**
     * @var TranslatorInterface
     */
    protected $translator;

    /**
     * Constructor.
     *
     * @param TranslatorInterface $translator
     */
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    /**
     * {@inheritdoc}
     *
     * The error_bubbling is set to false so we can render the hidden field errors ourselves
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('street', 'hidden', [
                'error_bubbling' => false,
                'constraints' => [
                    new NotBlank(['message' => $this->translator->trans('form.google_address.street.not_blank')]),
                    new Regex(['pattern' => '/(\d+)/', 'message' => $this->translator->trans('form.google_address.street.no_digit')]),
                ],
            ])
            ->add('zipcode', 'hidden', [
                'error_bubbling' => false,
                'constraints' => [
                    new NotBlank(['message' => $this->translator->trans('form.google_address.zipcode.not_blank')]),
                ],
            ])
            ->add('city', 'hidden', [
                'error_bubbling' => false,
                'constraints' => [
                    new NotBlank(['message' => $this->translator->trans('form.google_address.city.not_blank')]),
                ],
            ])
            ->add('country', 'hidden', [
                'error_bubbling' => false,
                'constraints' => [
                    new NotBlank(['message' => $this->translator->trans('form.google_address.country.not_blank')]),
                ],
            ])
            ->add('lat', 'hidden', [
                'error_bubbling' => false,
                'constraints' => [
                    new NotBlank(['message' => $this->translator->trans('form.google_address.lat.not_blank')]),
                ],
            ])
            ->add('lng', 'hidden', [
                'error_bubbling' => false,
                'constraints' => [
                    new NotBlank(['message' => $this->translator->trans('form.google_address.lng.not_blank')]),
                ],
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Opifer\CmsBundle\Entity\Address',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'google_address';
    }
}
