<?php

namespace Opifer\CmsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserFormType extends AbstractType
{
    /** @var array */
    protected $roles;

    /** @var string */
    protected $userClass;

    /**
     * Constructor.
     *
     * @param array  $roles
     * @param string $userClass
     */
    public function __construct(array $roles, $userClass)
    {
        $this->roles = $roles;
        $this->userClass = $userClass;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('enabled', ChoiceType::class, [
                'choices' => [
                    'form.options.enable' => true,
                    'form.options.disable' => false,
                ],
                'choices_as_values' => true,
                'data' => true,
            ])
            ->add('roles', ChoiceType::class, [
                'multiple' => true,
                'choices' => $this->flattenRoles($this->roles),
                'choices_as_values' => true,
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => $this->userClass,
        ]);
    }

    /**
     * Flatten roles.
     *
     * @param array $data
     *
     * @return array
     */
    public function flattenRoles($data)
    {
        $result = array();
        foreach ($data as $key => $value) {
            if (substr($key, 0, 4) === 'ROLE') {
                $result[$key] = $key;
            }
            if (is_array($value)) {
                $tmpresult = $this->flattenRoles($value);
                if (count($tmpresult) > 0) {
                    $result = array_merge($result, $tmpresult);
                }
            } else {
                $result[$value] = $value;
            }
        }

        return array_unique($result);
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return ProfileType::class;
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'user_form';
    }
}
